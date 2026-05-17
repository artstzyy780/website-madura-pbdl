<?php $__env->startSection('title','Data Produk'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <div>
    <h5 class="fw-bold mb-0">Semua Kategori</h5>
    <small class="text-muted"><?php echo e($kategori->count()); ?> kategori tersedia</small>
  </div>
  <div class="d-flex gap-2">
    <button class="btn btn-sm btn-outline-secondary rounded-circle" onclick="focusSearch()"><i class="bi bi-search"></i></button>
    <button class="btn btn-orange btn-sm rounded-circle" onclick="bukaModalTambah()"><i class="bi bi-plus-lg"></i></button>
  </div>
</div>

<div class="row g-3" id="gridKategori">
  <?php $__empty_1 = true; $__currentLoopData = $kategori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <div class="col-sm-6 col-lg-4">
    <div class="rounded-3 p-4 text-white text-center" style="background:<?php echo e($k->warna); ?>;cursor:pointer;min-height:120px;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.5rem;"
      onclick="window.location='<?php echo e(route('produk.index', $k)); ?>'">
      <i class="<?php echo e($k->icon ?? 'bi bi-box'); ?>" style="font-size:2rem;"></i>
      <div class="fw-bold"><?php echo e($k->nama); ?></div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <div class="col-12 text-center text-muted py-5">Belum ada kategori. Tambahkan kategori baru.</div>
  <?php endif; ?>
</div>


<div class="modal fade" id="modalKategori" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0"><h5 class="modal-title fw-bold">Tambahkan Kategori</h5><button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="background-color:#ef4444;border-radius:50%;opacity:1;"></button></div>
      <div class="modal-body">
        <input type="text" id="namaKategori" class="form-control mb-3" placeholder="Nama Kategori">
        <select id="ikonKategori" class="form-select mb-3">
          <option value="bi bi-bag-fill">🛍 Sembako / Belanja</option>
          <option value="bi bi-house-fill">🏠 Rumah Tangga</option>
          <option value="bi bi-cup-straw">🥤 Makanan & Minuman</option>
          <option value="bi bi-emoji-smile">😊 Rokok / Lainnya</option>
          <option value="bi bi-stars">⭐ Perawatan</option>
          <option value="bi bi-box">📦 Umum</option>
        </select>
        <input type="color" id="warnaKategori" class="form-control form-control-color mb-3" value="#3b82f6" title="Warna kartu">
        <textarea id="deskKategori" class="form-control" rows="3" placeholder="Deskripsi Produk"></textarea>
      </div>
      <div class="modal-footer border-0">
        <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-success rounded-pill px-4" onclick="simpanKategori()">Simpan</button>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function bukaModalTambah() { new bootstrap.Modal(document.getElementById('modalKategori')).show(); }
function focusSearch() { /* could add search functionality */ }

async function simpanKategori() {
  const nama  = document.getElementById('namaKategori').value.trim();
  const icon  = document.getElementById('ikonKategori').value;
  const warna = document.getElementById('warnaKategori').value;
  const desk  = document.getElementById('deskKategori').value;
  if (!nama) { alert('Nama kategori wajib diisi!'); return; }

  const res = await fetch('/data-produk/kategori', {
    method:'POST',
    headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
    body:JSON.stringify({nama,icon,warna,deskripsi:desk})
  });
  if (res.ok) { window.location.reload(); }
  else { const d = await res.json(); alert(d.message||'Gagal menyimpan'); }
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/kategori/index.blade.php ENDPATH**/ ?>