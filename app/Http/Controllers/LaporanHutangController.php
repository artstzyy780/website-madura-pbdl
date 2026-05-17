<?php
namespace App\Http\Controllers;
use App\Models\Transaksi;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanHutangController extends Controller {
    public function index(Request $request) {
        $dari   = $request->dari   ?? Carbon::today()->subDays(30)->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::today()->format('Y-m-d');

        $transaksi = Transaksi::with(['user'])
            ->where('is_draft', false)
            ->where('status', 'hutang')
            ->whereBetween(\DB::raw('DATE(created_at)'), [$dari, $sampai])
            ->orderByDesc('created_at')->get();

        $totalHutang = $transaksi->sum('total');
        $totalLunas  = 0;
        $jmlHutang   = $transaksi->count();
        $jmlLunas    = 0;

        if ($request->filled('dari') || $request->filled('sampai')) {
            AuditLog::catat('FILTER','Laporan',"Filter tanggal {$dari} - {$sampai}");
        }

        return view('laporan-hutang.index', compact('transaksi','dari','sampai','totalHutang','totalLunas','jmlHutang','jmlLunas'));
    }

    public function lunaskan(Transaksi $transaksi) {
        $transaksi->update(['status'=>'lunas']);
        AuditLog::catat('UPDATE','Laporan',"Lunaskan hutang: {$transaksi->no_nota}");
        return back()->with('success','Hutang berhasil dilunaskan');
    }

    public function exportExcel(Request $request) {
        AuditLog::catat('EXPORT','Excel','Export data transaksi ke Excel');
        $dari   = $request->dari   ?? Carbon::today()->subDays(30)->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::today()->format('Y-m-d');
        $transaksi = Transaksi::where('is_draft',false)
            ->where('status', 'hutang')
            ->whereBetween(\DB::raw('DATE(created_at)'),[$dari,$sampai])->get();
        $filename = "laporan_hutang_{$dari}_{$sampai}.csv";
        $headers  = ['Content-Type'=>'text/csv','Content-Disposition'=>"attachment; filename={$filename}"];
        $callback = function() use ($transaksi) {
            $f = fopen('php://output','w');
            fputcsv($f,['Tanggal','Pelanggan','Total','Status']);
            foreach ($transaksi as $t) {
                fputcsv($f,[$t->created_at->format('Y-m-d'),$t->nama_pembeli??'-',$t->total,$t->status]);
            }
            fclose($f);
        };
        return response()->stream($callback,200,$headers);
    }

    public function exportPdf(Request $request) {
        AuditLog::catat('EXPORT','PDF','Print/PDF laporan transaksi');
        $dari   = $request->dari   ?? Carbon::today()->subDays(30)->format('Y-m-d');
        $sampai = $request->sampai ?? Carbon::today()->format('Y-m-d');
        $transaksi   = Transaksi::where('is_draft',false)
            ->where('status', 'hutang')
            ->whereBetween(\DB::raw('DATE(created_at)'),[$dari,$sampai])->get();
        $totalHutang = $transaksi->where('status','hutang')->sum('total');
        $totalLunas  = $transaksi->where('status','lunas')->sum('total');
        return view('laporan-hutang.pdf', compact('transaksi','dari','sampai','totalHutang','totalLunas'));
    }
}
