@extends('layouts.app')
@section('title','Laporan Hutang')
@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="fw-bold mb-3">Laporan dan export</h5>
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
      <form class="d-flex align-items-center gap-2 flex-wrap" method="GET">
        <div class="input-group" style="width:280px;">
          <input type="date" name="dari" class="form-control form-control-sm" value="{{ $dari }}">
          <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
          <input type="date" name="sampai" class="form-control form-control-sm" value="{{ $sampai }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filter</button>
      </form>
      <a href="{{ route('laporan.excel', request()->query()) }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
      <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Tanggal</th><th>Pelanggan</th><th class="text-end">Total (Rp)</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($transaksi as $t)
          <tr>
            <td class="small">{{ $t->created_at->format('Y-m-d') }}</td>
            <td class="fw-semibold">{{ $t->nama_pembeli ?: '-' }}</td>
            <td class="text-end fw-semibold" style="color:#1a2fa0;">{{ number_format($t->total,0,',','.') }}</td>
            <td>
              @if($t->status === 'lunas')
                <span class="badge-lunas">Lunas</span>
              @else
                <span class="badge-hutang">Hutang</span>
              @endif
            </td>
            <td>
              @if($t->status === 'hutang')
                <form action="{{ route('laporan.lunas',$t) }}" method="POST" class="d-inline">
                  @csrf
                  <button type="submit" class="btn btn-success btn-sm py-0 px-2">lunaskan</button>
                </form>
              @else
                <span class="text-muted small">—</span>
              @endif
            </td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#fee2e2;">
      <div class="fw-bold text-danger small">Total Hutang</div>
      <div class="fw-bold fs-4 text-danger">Rp {{ number_format($totalHutang,0,',','.') }}</div>
      <div class="text-danger small">{{ $jmlHutang }} transaksi belum lunas</div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#d1fae5;">
      <div class="fw-bold text-success small">Total Lunas</div>
      <div class="fw-bold fs-4 text-success">Rp {{ number_format($totalLunas,0,',','.') }}</div>
      <div class="text-success small">{{ $jmlLunas }} transaksi lunas</div>
    </div>
  </div>
</div>
@endsection
