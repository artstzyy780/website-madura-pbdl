@extends('layouts.app')
@section('title','Dashboard')
@push('styles')
<style>
.input-bulan{border:1.5px solid #d1d5db;border-radius:8px;padding:.35rem .75rem;font-size:.85rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;}
.input-bulan:focus{outline:none;border-color:#1a2fa0;box-shadow:0 0 0 3px rgba(26,47,160,.1);}
</style>
@endpush
@section('content')
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <a href="{{ route('catatan.index') }}" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-journal-text"></i></div>
      <div class="sc-sub">Catatan</div>
      <div class="sc-title">Penjualan</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="{{ route('produk.kategori') }}" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-box-seam"></i></div>
      <div class="sc-sub">Data Produk</div>
      <div class="sc-title">by KATEGORI</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="{{ route('kasir.index') }}" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-cart-check"></i></div>
      <div class="sc-sub">&nbsp;</div>
      <div class="sc-title">Kasir</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="{{ route('access.index') }}" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-shield-lock"></i></div>
      <div class="sc-sub">&nbsp;</div>
      <div class="sc-title">Control Access</div>
    </a>
  </div>
</div>

<div class="card">
  <div class="card-body">

    {{-- Header + Filter Kalender --}}
    <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
      <h6 class="fw-bold mb-0">
        Statistik Penjualan &mdash; {{ $namaBulan[$bulan] }} {{ $tahun }}
      </h6>
      <form method="GET" id="filterForm">
        <input type="month"
               name="periode"
               class="input-bulan"
               value="{{ sprintf('%04d-%02d', $tahun, $bulan) }}"
               max="{{ now()->format('Y-m') }}"
               onchange="this.form.submit()">
      </form>
    </div>

    {{-- Chart --}}
    <div class="row align-items-center">
      <div class="col-lg-8">
        <canvas id="chartLaba" height="110"></canvas>
      </div>
      <div class="col-lg-4 text-center mt-3 mt-lg-0">
        <div style="width:64px;height:64px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.8rem;">💲</div>
        <div class="text-muted small mb-1">Status :</div>
        <div class="fw-bold {{ $status === 'untung' ? 'text-success' : 'text-danger' }}">{{ $status }}</div>
        <div class="fw-bold fs-3 {{ $status === 'untung' ? 'text-success' : 'text-danger' }} mt-1">
          {{ number_format(abs($laba),0,',','.') }}
        </div>
        <div class="text-muted small">Rupiah</div>
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chartLaba'),{
  type:'bar',
  data:{
    labels:['Total Penjualan','Modal Dikeluarkan'],
    datasets:[{
      data:[{{ $totalPenjualan }},{{ $modalDikeluarkan }}],
      backgroundColor:['#3b82f6','#6366f1'],
      borderRadius:8,
      barThickness:80
    }]
  },
  options:{
    plugins:{legend:{display:false}},
    responsive:true,
    scales:{
      y:{ticks:{callback:v=>parseInt(v).toLocaleString('id-ID')},grid:{color:'#f0f0f0'}},
      x:{grid:{display:false}}
    }
  }
});
</script>
@endpush
