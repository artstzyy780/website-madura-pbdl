<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Produk;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KasirController extends Controller {
    public function index() {
        $drafts = Transaksi::where('is_draft', true)
            ->where('user_id', auth()->id())
            ->orderByDesc('updated_at')->get();
        return view('kasir.index', compact('drafts'));
    }

    public function cariProduk(Request $request) {
        $kode = trim($request->get('kode',''));
        if (!$kode) return response()->json(['error' => 'Input kosong'], 400);

        $produk = Produk::where('is_active', true)
            ->where(function($q) use ($kode) {
                $q->where('kode', $kode)
                  ->orWhere('kode', 'like', "%{$kode}%")
                  ->orWhere('nama', 'like', "%{$kode}%");
            })
            ->limit(10)
            ->get();
            
        if ($produk->isEmpty()) return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        return response()->json($produk);
    }

    public function simpan(Request $request) {
        $request->validate([
            'items'           => 'required|array|min:1',
            'items.*.kode'    => 'required',
            'items.*.qty'     => 'required|integer|min:1',
            'metode_bayar'    => 'required',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $itemsData = [];
            foreach ($request->items as $item) {
                $produk = Produk::where('kode', $item['kode'])->where('is_active', true)->firstOrFail();
                $subtotal = $produk->harga_jual * $item['qty'];
                $total += $subtotal;
                $itemsData[] = [
                    'produk_id'   => $produk->id,
                    'kode_barang' => $produk->kode,
                    'nama_produk' => $produk->nama,
                    'qty'         => $item['qty'],
                    'harga'       => $produk->harga_jual,
                    'subtotal'    => $subtotal,
                    'created_at'  => now(),
                    'updated_at'  => now(),
                ];
            }

            $noNota = 'NOTA-'.Carbon::now()->format('Ymd').'-'.str_pad(
                Transaksi::whereDate('created_at', Carbon::today())->where('is_draft',false)->count()+1, 4,'0',STR_PAD_LEFT
            );

            $status = $request->metode_bayar === 'hutang' ? 'hutang' : 'lunas';

            $transaksi = Transaksi::create([
                'no_nota'      => $noNota,
                'user_id'      => auth()->id(),
                'nama_pembeli' => $request->nama_pembeli,
                'metode_bayar' => $request->metode_bayar,
                'total'        => $total,
                'status'       => $status,
                'is_draft'     => false,
            ]);

            foreach ($itemsData as &$i) $i['transaksi_id'] = $transaksi->id;
            TransaksiItem::insert($itemsData);

            // Hapus draft jika ada
            if ($request->draft_id) {
                Transaksi::where('id', $request->draft_id)->where('is_draft', true)->delete();
            }

            AuditLog::catat('CREATE', 'Transaksi', "Transaksi {$noNota} - Total Rp ".number_format($total,0,',','.'));
            DB::commit();
            return response()->json(['success'=>true,'no_nota'=>$noNota,'total'=>$total,'transaksi_id'=>$transaksi->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()], 422);
        }
    }

    public function simpanDraft(Request $request) {
        DB::beginTransaction();
        try {
            $total = 0;
            $itemsData = [];
            foreach (($request->items ?? []) as $item) {
                $produk = Produk::where('kode', $item['kode'])->firstOrFail();
                $subtotal = $produk->harga_jual * $item['qty'];
                $total += $subtotal;
                $itemsData[] = ['produk_id'=>$produk->id,'kode_barang'=>$produk->kode,'nama_produk'=>$produk->nama,'qty'=>$item['qty'],'harga'=>$produk->harga_jual,'subtotal'=>$subtotal,'created_at'=>now(),'updated_at'=>now()];
            }

            if ($request->draft_id) {
                $draft = Transaksi::findOrFail($request->draft_id);
                $draft->update(['nama_pembeli'=>$request->nama_pembeli,'total'=>$total]);
                TransaksiItem::where('transaksi_id',$draft->id)->delete();
                foreach ($itemsData as &$i) $i['transaksi_id'] = $draft->id;
                TransaksiItem::insert($itemsData);
                DB::commit();
                return response()->json(['success'=>true,'draft_id'=>$draft->id,'nama'=>$draft->nama_pembeli]);
            }

            $noNota = 'DRAFT-'.Carbon::now()->format('YmdHis').'-'.auth()->id();
            $draft = Transaksi::create([
                'no_nota'=>$noNota,'user_id'=>auth()->id(),
                'nama_pembeli'=>$request->nama_pembeli ?: 'Tanpa Nama',
                'metode_bayar'=>'cash','total'=>$total,'status'=>'lunas','is_draft'=>true,
            ]);
            foreach ($itemsData as &$i) $i['transaksi_id'] = $draft->id;
            if ($itemsData) TransaksiItem::insert($itemsData);
            DB::commit();
            return response()->json(['success'=>true,'draft_id'=>$draft->id,'nama'=>$draft->nama_pembeli]);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(['error'=>$e->getMessage()], 422);
        }
    }

    public function listDraft() {
        $drafts = Transaksi::where('is_draft', true)
            ->where('user_id', auth()->id())
            ->orderByDesc('updated_at')
            ->get(['id','nama_pembeli','total','updated_at']);
        return response()->json($drafts);
    }

    public function loadDraft(Transaksi $transaksi) {
        if (!$transaksi->is_draft || $transaksi->user_id !== auth()->id()) abort(403);
        return response()->json($transaksi->load('items'));
    }

    public function hapusDraft(Transaksi $transaksi) {
        if (!$transaksi->is_draft) abort(403);
        $transaksi->delete();
        return response()->json(['success'=>true]);
    }

    public function struk($id) {
        $transaksi = Transaksi::with(['items','user'])->findOrFail($id);
        $toko = \App\Models\TokoSetting::first();
        return view('kasir.struk', compact('transaksi','toko'));
    }
}
