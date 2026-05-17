<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\TokoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller {
    public function index(Request $request) {
        // Input type="month" mengirim format "YYYY-MM"
        $periode = $request->get('periode', now()->format('Y-m'));
        [$tahun, $bulan] = array_map('intval', explode('-', $periode));

        // Batasi agar tidak di luar batas wajar
        $bulan = max(1, min(12, $bulan));
        $tahun = max(2000, min((int) now()->year, $tahun));

        $awal  = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $akhir = $awal->copy()->endOfMonth();

        // Total penjualan bulan terpilih (lunas)
        $totalPenjualan = Transaksi::where('status', 'lunas')
            ->where('is_draft', false)
            ->whereBetween('created_at', [$awal, $akhir])
            ->sum('total');

        // Modal dikeluarkan bulan terpilih
        $modalDikeluarkan = DB::table('transaksi_item')
            ->join('transaksi', 'transaksi_item.transaksi_id', '=', 'transaksi.id')
            ->join('produk', 'transaksi_item.produk_id', '=', 'produk.id')
            ->where('transaksi.status', 'lunas')
            ->where('transaksi.is_draft', false)
            ->whereBetween('transaksi.created_at', [$awal, $akhir])
            ->sum(DB::raw('transaksi_item.qty * produk.harga_awal'));

        $laba   = $totalPenjualan - $modalDikeluarkan;
        $status = $laba >= 0 ? 'untung' : 'rugi';
        $toko   = TokoSetting::first();

        // Daftar bulan dalam bahasa Indonesia
        $namaBulan = ['', 'Januari','Februari','Maret','April','Mei','Juni',
                      'Juli','Agustus','September','Oktober','November','Desember'];

        return view('dashboard', compact(
            'totalPenjualan','modalDikeluarkan','laba','status','toko',
            'bulan','tahun','namaBulan'
        ));
    }
}
