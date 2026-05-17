<?php $__env->startSection('title','Laporan Hutang'); ?>
<?php $__env->startSection('content'); ?>
<div class="card">
  <div class="card-body">
    <h5 class="fw-bold mb-3">Laporan dan export</h5>
    <div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
      <form class="d-flex align-items-center gap-2 flex-wrap" method="GET">
        <div class="input-group" style="width:280px;">
          <input type="date" name="dari" class="form-control form-control-sm" value="<?php echo e($dari); ?>">
          <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
          <input type="date" name="sampai" class="form-control form-control-sm" value="<?php echo e($sampai); ?>">
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel me-1"></i>Filter</button>
      </form>
      <a href="<?php echo e(route('laporan.excel', request()->query())); ?>" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel me-1"></i>Excel</a>
      <a href="<?php echo e(route('laporan.pdf', request()->query())); ?>" class="btn btn-danger btn-sm" target="_blank"><i class="bi bi-file-earmark-pdf me-1"></i>PDF</a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover mb-0">
        <thead><tr><th>Tanggal</th><th>Pelanggan</th><th class="text-end">Total (Rp)</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          <?php $__empty_1 = true; $__currentLoopData = $transaksi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td class="small"><?php echo e($t->created_at->format('Y-m-d')); ?></td>
            <td class="fw-semibold"><?php echo e($t->nama_pembeli ?: '-'); ?></td>
            <td class="text-end fw-semibold" style="color:#1a2fa0;"><?php echo e(number_format($t->total,0,',','.')); ?></td>
            <td>
              <?php if($t->status === 'lunas'): ?>
                <span class="badge-lunas">Lunas</span>
              <?php else: ?>
                <span class="badge-hutang">Hutang</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if($t->status === 'hutang'): ?>
                <form action="<?php echo e(route('laporan.lunas',$t)); ?>" method="POST" class="d-inline">
                  <?php echo csrf_field(); ?>
                  <button type="submit" class="btn btn-success btn-sm py-0 px-2">lunaskan</button>
                </form>
              <?php else: ?>
                <span class="text-muted small">—</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada data</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#fee2e2;">
      <div class="fw-bold text-danger small">Total Hutang</div>
      <div class="fw-bold fs-4 text-danger">Rp <?php echo e(number_format($totalHutang,0,',','.')); ?></div>
      <div class="text-danger small"><?php echo e($jmlHutang); ?> transaksi belum lunas</div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="rounded-3 p-3" style="background:#d1fae5;">
      <div class="fw-bold text-success small">Total Lunas</div>
      <div class="fw-bold fs-4 text-success">Rp <?php echo e(number_format($totalLunas,0,',','.')); ?></div>
      <div class="text-success small"><?php echo e($jmlLunas); ?> transaksi lunas</div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/laporan-hutang/index.blade.php ENDPATH**/ ?>