<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Struk <?php echo e($transaksi->no_nota); ?></title>
<style>
body{font-family:'Courier New',monospace;font-size:12px;margin:0;padding:10px;width:300px;}
.center{text-align:center;}.bold{font-weight:bold;}.line{border-top:1px dashed #000;margin:6px 0;}
.row{display:flex;justify-content:space-between;}.total-row{display:flex;justify-content:space-between;font-weight:bold;font-size:14px;margin-top:4px;}
@media print{@page{margin:0;size:80mm auto;}body{width:auto;}.no-print{display:none;}}
</style>
</head>
<body>
<div class="center bold" style="font-size:16px"><?php echo e($toko?->nama_toko ?? "MADURA'S STORE"); ?></div>
<div class="center"><?php echo e($toko?->alamat ?? 'Point of Sale System'); ?></div>
<div class="line"></div>
<div class="row"><span>No Nota</span><span><?php echo e($transaksi->no_nota); ?></span></div>
<div class="row"><span>Tgl</span><span><?php echo e($transaksi->created_at->format('d/m/Y H:i')); ?></span></div>
<div class="row"><span>Kasir</span><span><?php echo e($transaksi->user->name); ?></span></div>
<?php if($transaksi->nama_pembeli): ?><div class="row"><span>Pembeli</span><span><?php echo e($transaksi->nama_pembeli); ?></span></div><?php endif; ?>
<div class="line"></div>
<?php $__currentLoopData = $transaksi->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div><?php echo e($item->nama_produk); ?></div>
<div class="row">
  <span>&nbsp;&nbsp;<?php echo e($item->qty); ?> x Rp<?php echo e(number_format($item->harga,0,',','.')); ?></span>
  <span><?php echo e(number_format($item->subtotal,0,',','.')); ?></span>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<div class="line"></div>
<div class="total-row"><span>TOTAL</span><span>Rp <?php echo e(number_format($transaksi->total,0,',','.')); ?></span></div>
<div class="row"><span>Metode</span><span><?php echo e(strtoupper($transaksi->metode_bayar)); ?></span></div>
<?php if($transaksi->status === 'hutang'): ?><div class="center bold" style="color:red;margin-top:4px;">*** HUTANG ***</div><?php endif; ?>
<div class="line"></div>
<div class="center">Terima kasih telah berbelanja!</div>
<div class="no-print" style="margin-top:20px;text-align:center;">
  <button onclick="window.print()" style="padding:8px 20px;background:#1a2fa0;color:#fff;border:none;border-radius:6px;cursor:pointer;">🖨 Cetak</button>
  <button onclick="window.close()" style="padding:8px 20px;background:#6b7280;color:#fff;border:none;border-radius:6px;cursor:pointer;margin-left:8px;">✕ Tutup</button>
</div>
<script>window.onload = () => window.print();</script>
</body>
</html>
<?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/kasir/struk.blade.php ENDPATH**/ ?>