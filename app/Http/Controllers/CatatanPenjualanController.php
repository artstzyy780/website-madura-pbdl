<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CatatanPenjualanController extends Controller {
    public function index(Request $request) {
        $dari   = $request->dari   ?? Carbon::today()->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::today()->format('Y-m-d');

        $query = Transaksi::with(['items','user'])
            ->where('is_draft', false)
            ->where('status', 'lunas')
            ->whereBetween(\DB::raw('DATE(created_at)'), [$dari, $sampai])
            ->orderByDesc('created_at');

        $transaksi   = $query->get();
        $totalLunas  = $transaksi->sum('total');
        $totalHutang = 0;
        $jmlLunas    = $transaksi->count();
        $jmlHutang   = 0;

        if ($request->ajax() && $request->get('export') === 'json') {
            return response()->json(compact('transaksi','totalLunas','totalHutang'));
        }

        return view('catatan-penjualan.index', compact('transaksi','dari','sampai','totalLunas','totalHutang','jmlLunas','jmlHutang'));
    }

    public function lunaskan(Transaksi $transaksi) {
        $transaksi->update(['status'=>'lunas','metode_bayar'=>'cash']);
        AuditLog::catat('UPDATE','Transaksi',"Lunaskan transaksi: {$transaksi->no_nota}");
        return back()->with('success','Transaksi berhasil dilunaskan');
    }

    public function exportExcel(Request $request) {
        AuditLog::catat('EXPORT','Excel','Export data transaksi ke Excel');
        // Dengan library PhpSpreadsheet jika tersedia, atau CSV fallback
        $dari   = $request->dari   ?? Carbon::today()->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::today()->format('Y-m-d');
        $transaksi = Transaksi::with('items')
            ->where('is_draft',false)
            ->where('status', 'lunas')
            ->whereBetween(\DB::raw('DATE(created_at)'), [$dari, $sampai])
            ->get();

        $filename = "laporan_{$dari}_{$sampai}.csv";
        $headers  = ['Content-Type'=>'text/csv','Content-Disposition'=>"attachment; filename={$filename}"];
        $callback = function() use ($transaksi) {
            $f = fopen('php://output','w');
            fputcsv($f, ['No Nota','Waktu','Nama Pembeli','Item','Total','Status','Metode']);
            foreach ($transaksi as $t) {
                $items = $t->items->map(fn($i)=>"{$i->qty}x {$i->kode_barang}")->implode(', ');
                fputcsv($f, [$t->no_nota, $t->created_at->format('H:i'), $t->nama_pembeli??'-', $items, $t->total, $t->status, $t->metode_bayar]);
            }
            fclose($f);
        };
        return response()->stream($callback, 200, $headers);
    }
}
