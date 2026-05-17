@extends('layouts.app')
@section('title','Catatan Penjualan')
@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="fw-bold mb-3">Catatan Penjualan</h5>
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
      <form class="d-flex align-items-center gap-2 flex-wrap" method="GET">
        <div class="input-group" style="width:280px;">
          <input type="date" name="dari" class="form-control form-control-sm" value="{{ $dari }}">
          <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
          <input type="date" name="sampai" class="form-control form-control-sm" value="{{ $sampai }}">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filter</button>
      </form>
      <a href="{{ route('catatan.excel', request()->query()) }}" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
      <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead>
          <tr style="background:#1a2fa0;">
            <th style="color:#111;border:none;">No. Nota</th>
            <th style="color:#111;border:none;">Waktu</th>
            <th style="color:#111;border:none;">Item</th>
            <th style="color:#111;border:none;">Total Harga</th>
            <th style="color:#111;border:none;">Status</th>
            <th style="color:#111;border:none;">Edit</th>
          </tr>
        </thead>
        <tbody>
          @forelse($transaksi as $t)
          <tr>
            <td class="font-monospace fw-semibold small">{{ $t->no_nota }}</td>
            <td>{{ $t->created_at->format('H:i') }}</td>
            <td class="small">
              @php $items = $t->items; @endphp
              @if($items->count() > 0)
                {{ $items->first()->qty }} pcs {{ $items->first()->kode_barang }}
                @if($items->count() > 1) <span class="text-muted">+{{ $items->count()-1 }} lainnya</span>@endif
              @else - @endif
            </td>
            <td class="fw-semibold" style="color:#1a2fa0;">Rp. {{ number_format($t->total,0,',','.') }}</td>
            <td>
              @if($t->status === 'lunas')
                <span class="badge-lunas">Lunas</span>
              @else
                <span class="badge-hutang">Belum Lunas</span>
              @endif
            </td>
            <td>
              <a href="{{ route('kasir.struk',$t->id) }}" target="_blank" class="btn btn-sm btn-outline-primary py-0 px-2"><i class="bi bi-receipt"></i></a>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center text-muted py-4">Tidak ada transaksi pada periode ini</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#d1fae5;">
      <div class="fw-bold text-success small">Total Lunas</div>
      <div class="fw-bold fs-4 text-success">Rp {{ number_format($totalLunas,0,',','.') }}</div>
      <div class="text-success small">{{ $jmlLunas }} transaksi lunas</div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#fee2e2;">
      <div class="fw-bold text-danger small">Belum Lunas</div>
      <div class="fw-bold fs-4 text-danger">Rp {{ number_format($totalHutang,0,',','.') }}</div>
      <div class="text-danger small">{{ $jmlHutang }} transaksi belum lunas</div>
    </div>
  </div>
</div>
@endsection
