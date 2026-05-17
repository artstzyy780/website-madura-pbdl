<?php $__env->startSection('title','Settings'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex align-items-center gap-3 mb-4">
  <div style="width:48px;height:48px;background:#1a2fa0;border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.4rem;">
    <i class="bi bi-gear-fill"></i>
  </div>
  <div>
    <h5 class="fw-bold mb-0">Settings</h5>
    <small class="text-muted">Kelola preferensi dan konfigurasi toko Anda</small>
  </div>
</div>

<ul class="nav nav-tabs mb-4" id="settingTab">
  <li class="nav-item">
    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tabProfile">
      <i class="bi bi-person me-1"></i>My Profile
    </button>
  </li>
  <li class="nav-item">
    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tabBusiness">
      <i class="bi bi-shop me-1"></i>Business Settings
    </button>
  </li>
</ul>

<div class="tab-content">
  
  <div class="tab-pane fade show active" id="tabProfile">
    <div class="card">
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-4 text-center">
            <div class="position-relative d-inline-block mb-3">
              <img id="previewFoto"
                src="<?php echo e($user->foto ? asset('uploads/user/'.$user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f97316&color=fff&size=120'); ?>"
                style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:3px solid #f97316;">
              <label for="inputFoto" style="position:absolute;bottom:0;right:0;width:28px;height:28px;background:#1a2fa0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;font-size:.8rem;">
                <i class="bi bi-camera"></i>
              </label>
            </div>
            <div class="fw-bold"><?php echo e($user->name); ?></div>
            <div class="text-muted small"><?php echo e(ucfirst($user->role)); ?></div>
            <div class="mt-2 d-flex flex-column gap-1 align-items-center">
              <span class="badge bg-light text-success border border-success small"><i class="bi bi-bell me-1"></i>Notifikasi Aktif</span>
              <span class="badge bg-light text-primary border border-primary small"><i class="bi bi-globe me-1"></i>Bahasa: Indonesia</span>
            </div>
          </div>
          <div class="col-md-8">
            <h6 class="fw-bold mb-1">Informasi Profil</h6>
            <p class="text-muted small mb-3">Perbarui data profil akun Anda</p>
            <form action="<?php echo e(route('settings.profile')); ?>" method="POST" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>
              <input type="file" id="inputFoto" name="foto" class="d-none" accept="image/*" onchange="previewImg(this)">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label small">Nama Lengkap</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control" value="<?php echo e($user->name); ?>" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Email</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control" value="<?php echo e($user->email); ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Nomor Telepon</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                    <input type="text" name="telepon" class="form-control" value="<?php echo e($user->telepon); ?>" placeholder="+62 812-XXXX-XXXX">
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label small">Alamat</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                    <input type="text" name="alamat" class="form-control" value="<?php echo e($user->alamat); ?>">
                  </div>
                </div>
              </div>
              <div class="d-flex gap-2 mt-4">
                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Batal</button>
                <button type="submit" class="btn btn-blue px-4"><i class="bi bi-floppy me-1"></i>Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div class="tab-pane fade" id="tabBusiness">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div>
            <h6 class="fw-bold mb-1"><i class="bi bi-shop me-2"></i>Edit Info Toko</h6>
            <p class="text-muted small mb-0">Perbaruhi nama toko dan alamat toko anda</p>
          </div>
        </div>
        <form action="<?php echo e(route('settings.toko')); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <div class="row g-3 mb-3">
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Nama</label>
              <input type="text" name="nama_toko" class="form-control" value="<?php echo e($toko->nama_toko); ?>">
            </div>
            <div class="col-md-6">
              <label class="form-label small fw-semibold">Alamat</label>
              <input type="text" name="alamat" class="form-control" value="<?php echo e($toko->alamat); ?>">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small fw-semibold">Logo toko</label>
            <div class="d-flex align-items-center gap-3">
              <div class="position-relative">
                <img id="previewLogo"
                  src="<?php echo e($toko->logo ? asset('uploads/toko/'.$toko->logo) : 'https://ui-avatars.com/api/?name=M&background=f97316&color=fff&size=80'); ?>"
                  style="width:60px;height:60px;border-radius:50%;object-fit:cover;border:2px solid #f97316;">
                <label for="inputLogo" style="position:absolute;bottom:0;right:0;width:22px;height:22px;background:#1a2fa0;border-radius:50%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:#fff;font-size:.7rem;">
                  <i class="bi bi-camera"></i>
                </label>
              </div>
              <label for="inputLogo" class="border border-2 border-dashed rounded-3 p-3 text-center flex-fill" style="cursor:pointer;color:#6b7280;">
                <i class="bi bi-cloud-arrow-up fs-4 d-block text-primary mb-1"></i>
                <span class="fw-semibold text-primary small">click and Update</span><br>
                <span class="small">PNG, JPG, WEBP (max 2MB)</span>
              </label>
              <input type="file" id="inputLogo" name="logo" class="d-none" accept="image/*" onchange="previewLogoImg(this)">
            </div>
          </div>
          <div class="mb-4">
            <label class="form-label small fw-semibold">Role</label>
            <input type="text" class="form-control bg-light" value="<?php echo e(ucfirst(auth()->user()->role)); ?>" readonly>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-secondary" onclick="history.back()">× cancel</button>
            <button type="submit" class="btn btn-blue px-4"><i class="bi bi-floppy me-1"></i>Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
function previewImg(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('previewFoto').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}
function previewLogoImg(input) {
  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = e => document.getElementById('previewLogo').src = e.target.result;
    reader.readAsDataURL(input.files[0]);
  }
}
// Auto switch to Business Settings tab if ?tab=business
if (window.location.search.includes('tab=business')) {
  document.querySelector('[data-bs-target="#tabBusiness"]').click();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/settings/index.blade.php ENDPATH**/ ?>