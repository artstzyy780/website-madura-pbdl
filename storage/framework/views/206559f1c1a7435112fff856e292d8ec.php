<?php $__env->startSection('title','Produk - ' . $kategori->nama); ?>
<?php $__env->startPush('styles'); ?>
<style>
.produk-card{border-radius:12px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,.08);background:#fff;position:relative;transition:transform .15s;}
.produk-card:hover{transform:translateY(-3px);box-shadow:0 6px 20px rgba(0,0,0,.12);}
.produk-img{width:100%;aspect-ratio:1;object-fit:cover;background:#e5e7eb;display:block;}
.produk-img-ph{width:100%;aspect-ratio:1;background:#e5e7eb;display:flex;align-items:center;justify-content:center;font-size:3rem;color:#9ca3af;}
.produk-body{padding:.75rem;}
.produk-nama{font-weight:700;font-size:.9rem;margin-bottom:.25rem;}
.produk-price{font-size:.8rem;color:#6b7280;}
.produk-price strong{color:#1a2fa0;}
.fab-group{position:absolute;bottom:.5rem;right:.5rem;display:flex;gap:.35rem;}
.edit-fab{width:32px;height:32px;border-radius:50%;background:#3b82f6;color:#fff;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.85rem;}
.del-fab{width:32px;height:32px;border-radius:50%;background:#ef4444;color:#fff;border:none;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:.85rem;transition:background .15s;}
.del-fab:hover{background:#dc2626;}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center justify-content-between mb-3">
  <div class="d-flex align-items-center gap-2">
    <a href="<?php echo e(route('produk.kategori')); ?>" class="btn btn-sm btn-outline-secondary rounded-circle"><i class="bi bi-arrow-left"></i></a>
    <h5 class="fw-bold mb-0"><?php echo e($kategori->nama); ?></h5>
  </div>
  <div class="d-flex gap-2 align-items-center">
    <div class="input-group input-group-sm" style="width:200px;">
      <span class="input-group-text"><i class="bi bi-search"></i></span>
      <input type="text" class="form-control" placeholder="Cari produk..." id="searchInput" value="<?php echo e($search); ?>"
        onkeydown="if(event.key==='Enter') window.location='?q='+this.value">
    </div>
    <button class="btn btn-orange btn-sm rounded-circle" onclick="bukaModalTambah()"><i class="bi bi-plus-lg"></i></button>
  </div>
</div>

<div class="row g-3" id="gridProduk">
  <?php $__empty_1 = true; $__currentLoopData = $produk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
  <div class="col-6 col-md-4 col-xl-3">
    <div class="produk-card">
      <?php if($p->foto): ?>
        <img src="<?php echo e(asset('uploads/produk/'.$p->foto)); ?>" class="produk-img" alt="<?php echo e($p->nama); ?>">
      <?php else: ?>
        <div class="produk-img-ph"><i class="bi bi-image"></i></div>
      <?php endif; ?>
      <div class="produk-body">
        <div class="produk-nama"><?php echo e($p->nama); ?></div>
        <div class="produk-price">Harga Jual:<br><strong>Rp <?php echo e(number_format($p->harga_jual,0,',','.')); ?>,-</strong></div>
        <div class="produk-price mt-1">Modal Awal:<br>Rp <?php echo e(number_format($p->harga_awal,0,',','.')); ?>,-</div>
      </div>
      <div class="fab-group">
        <button class="del-fab" onclick="hapusProduk(<?php echo e($p->id); ?>, '<?php echo e(addslashes($p->nama)); ?>', this)"><i class="bi bi-trash"></i></button>
        <button class="edit-fab" onclick='editProduk(<?php echo e(json_encode($p)); ?>)'><i class="bi bi-pencil"></i></button>
      </div>
    </div>
  </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
  <div class="col-12 text-center text-muted py-5">Belum ada produk di kategori ini.</div>
  <?php endif; ?>
</div>


<div class="modal fade" id="modalProduk" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="modalProdukTitle">Tambahkan Produk</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="background-color:#ef4444;border-radius:50%;opacity:1;"></button>
      </div>
      <form id="formProduk" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="_method" id="produkMethod" value="POST">
        <input type="hidden" id="produkId" value="">
        <div class="modal-body">
          <input type="text" name="kode" id="fKode" class="form-control mb-2" placeholder="Kode Produk (contoh: YKT150)" required>
          <input type="text" name="nama" id="fNama" class="form-control mb-2" placeholder="Nama Produk" required>
          <input type="text" name="merk" id="fMerk" class="form-control mb-2" placeholder="Merk Produk">
          <div class="input-group mb-2">
            <span class="input-group-text">Rp.</span>
            <input type="number" name="harga_awal" id="fModal" class="form-control" placeholder="Harga Awal (Modal)" required min="0">
          </div>
          <div class="input-group mb-2">
            <span class="input-group-text">Rp.</span>
            <input type="number" name="harga_jual" id="fHarga" class="form-control" placeholder="Harga Produk (Jual)" required min="0">
          </div>
          <input type="hidden" name="kategori_id" value="<?php echo e($kategori->id); ?>">
          <textarea name="deskripsi" id="fDesk" class="form-control mb-2" rows="2" placeholder="Deskripsi Produk"></textarea>
          <input type="file" name="foto" id="fFoto" class="form-control" accept="image/*">
        </div>
        <div class="modal-footer border-0">
          <button type="button" class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
          <button type="submit" id="btnSimpan" class="btn btn-success rounded-pill px-4">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="modalSukses" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow" style="border-radius:16px;">
      <div class="modal-body text-center py-4 px-3">
        <div style="font-size:3rem;margin-bottom:.5rem;">✅</div>
        <h6 class="fw-bold mb-1" id="suksesTeks">Produk berhasil disimpan!</h6>
        <p class="text-muted small mb-0">Data telah diperbarui.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalHapus" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow" style="border-radius:16px;">
      <div class="modal-body text-center py-4 px-3">
        <div style="font-size:2.5rem;margin-bottom:.5rem;">🗑️</div>
        <h6 class="fw-bold mb-1">Hapus Produk?</h6>
        <p class="text-muted small mb-3" id="hapusNamaTeks">Produk ini tidak akan muncul lagi.</p>
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-danger rounded-pill px-4" id="btnKonfirmasiHapus">Hapus</button>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
let actionUrl = '';

function bukaModalTambah() {
  actionUrl = '<?php echo e(route("produk.store", $kategori)); ?>';
  document.getElementById('modalProdukTitle').textContent = 'Tambahkan Produk';
  document.getElementById('produkMethod').value = 'POST';
  document.getElementById('fKode').value = '';
  document.getElementById('fNama').value = '';
  document.getElementById('fMerk').value = '';
  document.getElementById('fModal').value = '';
  document.getElementById('fHarga').value = '';
  document.getElementById('fDesk').value = '';
  document.getElementById('fFoto').value = '';
  new bootstrap.Modal(document.getElementById('modalProduk')).show();
}

function editProduk(p) {
  actionUrl = `/data-produk/item/${p.id}`;
  document.getElementById('modalProdukTitle').textContent = 'Edit Produk';
  document.getElementById('produkMethod').value = 'PUT';
  document.getElementById('fKode').value  = p.kode;
  document.getElementById('fNama').value  = p.nama;
  document.getElementById('fMerk').value  = p.merk || '';
  document.getElementById('fModal').value = p.harga_awal;
  document.getElementById('fHarga').value = p.harga_jual;
  document.getElementById('fDesk').value  = p.deskripsi || '';
  document.getElementById('fFoto').value  = '';
  new bootstrap.Modal(document.getElementById('modalProduk')).show();
}

document.getElementById('formProduk').addEventListener('submit', async function(e) {
  e.preventDefault();
  const btn = document.getElementById('btnSimpan');
  btn.disabled = true;
  btn.textContent = 'Menyimpan...';

  const formData = new FormData(this);

  try {
    const res = await fetch(actionUrl, {
      method: 'POST',
      headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' },
      body: formData
    });
    const json = await res.json();

    if (json.success) {
      // Tutup modal form
      bootstrap.Modal.getInstance(document.getElementById('modalProduk')).hide();

      // Tampilkan modal sukses
      const isEdit = document.getElementById('produkMethod').value === 'PUT';
      document.getElementById('suksesTeks').textContent = isEdit
        ? 'Produk berhasil diperbarui!'
        : 'Produk berhasil ditambahkan!';
      const modalSukses = new bootstrap.Modal(document.getElementById('modalSukses'));
      modalSukses.show();

      // Reload halaman setelah 1.5 detik
      setTimeout(() => { window.location.reload(); }, 1500);
    } else {
      alert('Gagal menyimpan produk. Coba lagi.');
    }
  } catch (err) {
    alert('Terjadi kesalahan. Coba lagi.');
    console.error(err);
  } finally {
    btn.disabled = false;
    btn.textContent = 'Simpan';
  }
});
let _hapusId = null, _hapusBtn = null;

function hapusProduk(id, nama, btn) {
  _hapusId  = id;
  _hapusBtn = btn;
  document.getElementById('hapusNamaTeks').textContent = `"${nama}" tidak akan muncul lagi di daftar.`;
  new bootstrap.Modal(document.getElementById('modalHapus')).show();
}

document.getElementById('btnKonfirmasiHapus').addEventListener('click', async function() {
  const modalEl = document.getElementById('modalHapus');
  bootstrap.Modal.getInstance(modalEl)?.hide();
  try {
    const res = await fetch(`/data-produk/item/${_hapusId}`, {
      method: 'DELETE',
      headers: { 'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>', 'Accept': 'application/json' }
    });
    const json = await res.json();
    if (json.success) {
      _hapusBtn.closest('[class*="col-"]').remove();
    } else {
      alert('Gagal menghapus produk.');
    }
  } catch(err) {
    alert('Terjadi kesalahan.');
    console.error(err);
  }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/produk/index.blade.php ENDPATH**/ ?>