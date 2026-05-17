<?php $__env->startSection('title','Dashboard'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.input-bulan{border:1.5px solid #d1d5db;border-radius:8px;padding:.35rem .75rem;font-size:.85rem;font-weight:600;color:#374151;background:#fff;cursor:pointer;}
.input-bulan:focus{outline:none;border-color:#1a2fa0;box-shadow:0 0 0 3px rgba(26,47,160,.1);}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
  <div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('catatan.index')); ?>" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-journal-text"></i></div>
      <div class="sc-sub">Catatan</div>
      <div class="sc-title">Penjualan</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('produk.kategori')); ?>" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-box-seam"></i></div>
      <div class="sc-sub">Data Produk</div>
      <div class="sc-title">by KATEGORI</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('kasir.index')); ?>" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-cart-check"></i></div>
      <div class="sc-sub">&nbsp;</div>
      <div class="sc-title">Kasir</div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-3">
    <a href="<?php echo e(route('access.index')); ?>" class="shortcut-card">
      <div class="sc-icon"><i class="bi bi-shield-lock"></i></div>
      <div class="sc-sub">&nbsp;</div>
      <div class="sc-title">Control Access</div>
    </a>
  </div>
</div>

<div class="card">
  <div class="card-body">

    
    <div class="d-flex align-items-center gap-3 flex-wrap mb-4">
      <h6 class="fw-bold mb-0">
        Statistik Penjualan &mdash; <?php echo e($namaBulan[$bulan]); ?> <?php echo e($tahun); ?>

      </h6>
      <form method="GET" id="filterForm">
        <input type="month"
               name="periode"
               class="input-bulan"
               value="<?php echo e(sprintf('%04d-%02d', $tahun, $bulan)); ?>"
               max="<?php echo e(now()->format('Y-m')); ?>"
               onchange="this.form.submit()">
      </form>
    </div>

    
    <div class="row align-items-center">
      <div class="col-lg-8">
        <canvas id="chartLaba" height="110"></canvas>
      </div>
      <div class="col-lg-4 text-center mt-3 mt-lg-0">
        <div style="width:64px;height:64px;background:#d1fae5;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-size:1.8rem;">💲</div>
        <div class="text-muted small mb-1">Status :</div>
        <div class="fw-bold <?php echo e($status === 'untung' ? 'text-success' : 'text-danger'); ?>"><?php echo e($status); ?></div>
        <div class="fw-bold fs-3 <?php echo e($status === 'untung' ? 'text-success' : 'text-danger'); ?> mt-1">
          <?php echo e(number_format(abs($laba),0,',','.')); ?>

        </div>
        <div class="text-muted small">Rupiah</div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('chartLaba'),{
  type:'bar',
  data:{
    labels:['Total Penjualan','Modal Dikeluarkan'],
    datasets:[{
      data:[<?php echo e($totalPenjualan); ?>,<?php echo e($modalDikeluarkan); ?>],
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/dashboard.blade.php ENDPATH**/ ?>