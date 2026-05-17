<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title','Madura\'s Store'); ?></title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
:root{--sidebar-w:180px;--blue:#1a2fa0;--blue-dark:#111e78;--orange:#f97316;--orange-dark:#ea6200;}
*{box-sizing:border-box;}
body{font-family:'Segoe UI',sans-serif;background:#f0f2f8;margin:0;}
/* Sidebar */
.sidebar{position:fixed;top:0;left:0;bottom:0;width:var(--sidebar-w);background:var(--blue-dark);display:flex;flex-direction:column;z-index:1000;}
.sidebar-brand{padding:.75rem 1.2rem;background:var(--blue);border-bottom:1px solid rgba(255,255,255,.1);height:60px;display:flex;flex-direction:column;justify-content:center;}
.sidebar-brand .toko-name{color:#fff;font-weight:700;font-size:.95rem;line-height:1.2;}
.sidebar-brand .toko-sub{color:rgba(255,255,255,.5);font-size:.7rem;}
.sidebar-avatar{padding:1.2rem 1.2rem .5rem;text-align:center;}
.sidebar-avatar img{width:60px;height:60px;border-radius:50%;border:3px solid var(--orange);object-fit:cover;}
.sidebar-avatar .av-name{color:#fff;font-size:.85rem;font-weight:600;margin-top:.5rem;}
.sidebar-avatar .av-sub{color:rgba(255,255,255,.5);font-size:.7rem;}
.sidebar-nav{flex:1;padding:.5rem 0;}
.sidebar-nav a{display:flex;align-items:center;gap:.6rem;padding:.65rem 1.2rem;color:rgba(255,255,255,.7);text-decoration:none;font-size:.85rem;transition:all .15s;border-left:3px solid transparent;}
.sidebar-nav a:hover,.sidebar-nav a.active{background:var(--orange);color:#fff;border-left-color:#fff;}
.sidebar-nav a i{font-size:1rem;width:1.2rem;text-align:center;}
/* Topbar */
.main-content{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column;}
.topbar{background:var(--blue);padding:.75rem 1.5rem;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:100;height:60px;}
.topbar-title{color:#fff;font-weight:700;font-size:1.1rem;}
.topbar-user{display:flex;align-items:center;gap:.75rem;}
.topbar-user .uname{text-align:right;}
.topbar-user .uname-text{color:#fff;font-size:.85rem;font-weight:600;}
.topbar-user .uname-role{color:rgba(255,255,255,.6);font-size:.7rem;}
.topbar-user img{width:38px;height:38px;border-radius:50%;object-fit:cover;border:2px solid var(--orange);}
.content-area{padding:1.25rem;flex:1;}
/* Cards orange */
.shortcut-card{background:var(--blue-dark);border-radius:12px;padding:1.2rem;color:#fff;cursor:pointer;text-decoration:none;display:block;transition:transform .15s,box-shadow .15s;border:none;}
.shortcut-card:hover{transform:translateY(-3px);box-shadow:0 8px 24px rgba(0,0,0,.2);color:#fff;}
.shortcut-card .sc-icon{font-size:1.8rem;color:var(--orange);margin-bottom:.5rem;}
.shortcut-card .sc-sub{font-size:.7rem;opacity:.6;}
.shortcut-card .sc-title{font-size:.95rem;font-weight:700;color:var(--orange);}
/* General */
.card{border:none;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.card-header{background:#fff;border-bottom:1px solid #eee;font-weight:600;border-radius:12px 12px 0 0!important;}
.btn-orange{background:var(--orange);color:#fff;border:none;border-radius:8px;}
.btn-orange:hover{background:var(--orange-dark);color:#fff;}
.btn-blue{background:var(--blue);color:#fff;border:none;border-radius:8px;}
.btn-blue:hover{background:var(--blue-dark);color:#fff;}
.table th{font-size:.78rem;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;background:#f9fafb;}
.table td{vertical-align:middle;font-size:.88rem;}
.badge-lunas{background:#d1fae5;color:#065f46;padding:.25rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600;}
.badge-hutang{background:#fee2e2;color:#991b1b;padding:.25rem .6rem;border-radius:20px;font-size:.75rem;font-weight:600;}
.badge-on-air{background:#d1fae5;color:#065f46;padding:.25rem .6rem;border-radius:20px;font-size:.75rem;}
.badge-libur{background:#fee2e2;color:#991b1b;padding:.25rem .6rem;border-radius:20px;font-size:.75rem;}
</style>
<?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<?php $toko = \App\Models\TokoSetting::first(); $user = auth()->user(); ?>
<div class="sidebar">
  <div class="sidebar-brand">
    <?php if($toko?->logo): ?>
      <img src="<?php echo e(asset('uploads/toko/'.$toko->logo)); ?>" style="height:32px;margin-bottom:.3rem;display:block;">
    <?php endif; ?>
    <div class="toko-name"><?php echo e($toko?->nama_toko ?? "Madura's Store"); ?></div>
  </div>
  <div class="sidebar-avatar">
    <img src="<?php echo e($user->foto ? asset('uploads/user/'.$user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f97316&color=fff'); ?>" alt="">
    <div class="av-name"><?php echo e($user->name); ?></div>
    <div class="av-sub"><?php echo e($toko?->nama_toko ?? "Madura's Store"); ?></div>
  </div>
  <nav class="sidebar-nav">
    <?php if(auth()->user()->role === 'admin'): ?>
      <a href="<?php echo e(route('dashboard')); ?>"         class="<?php echo e(request()->routeIs('dashboard') ? 'active':''); ?>"><i class="bi bi-speedometer2"></i> Dashboard</a>
    <?php endif; ?>
    <a href="<?php echo e(route('kasir.index')); ?>"        class="<?php echo e(request()->routeIs('kasir.*') ? 'active':''); ?>"><i class="bi bi-cart3"></i> Kasir</a>
    <?php if(auth()->user()->role === 'admin'): ?>
      <a href="<?php echo e(route('produk.kategori')); ?>"    class="<?php echo e(request()->routeIs('produk.*') ? 'active':''); ?>"><i class="bi bi-box-seam"></i> Data Produk</a>
      <a href="<?php echo e(route('catatan.index')); ?>"      class="<?php echo e(request()->routeIs('catatan.*') ? 'active':''); ?>"><i class="bi bi-journal-text"></i> Catatan Penjualan</a>
      <a href="<?php echo e(route('access.index')); ?>"       class="<?php echo e(request()->routeIs('access.*') ? 'active':''); ?>"><i class="bi bi-shield-lock"></i> Control Access</a>
    <?php endif; ?>
    <a href="<?php echo e(route('laporan.index')); ?>"      class="<?php echo e(request()->routeIs('laporan.*') ? 'active':''); ?>"><i class="bi bi-book"></i> Laporan Hutang</a>
    <?php if(auth()->user()->role === 'admin'): ?>
      <a href="<?php echo e(route('settings.index')); ?>"     class="<?php echo e(request()->routeIs('settings.*') ? 'active':''); ?>"><i class="bi bi-gear"></i> Settings</a>
    <?php endif; ?>
  </nav>
</div>
<div class="main-content">
  <div class="topbar">
    <div class="topbar-title">
      <a href="<?php echo e(auth()->user()->role === 'admin' ? route('dashboard') : route('kasir.index')); ?>" style="color:#fff;font-size:1.2rem;line-height:1;"><i class="bi bi-arrow-left"></i></a>
    </div>
    <div class="topbar-user">
      <div class="uname">
        <div class="uname-text"><?php echo e($user->name); ?></div>
        <div class="uname-role"><?php echo e(ucfirst($user->role)); ?></div>
      </div>
      <img src="<?php echo e($user->foto ? asset('uploads/user/'.$user->foto) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=f97316&color=fff'); ?>" alt="">
      <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
        <?php echo csrf_field(); ?><button type="submit" class="btn btn-sm btn-link text-white p-0 ms-1" title="Logout"><i class="bi bi-box-arrow-right fs-5"></i></button>
      </form>
    </div>
  </div>
  <div class="content-area">
    <?php if(session('success')): ?><div class="alert alert-success alert-dismissible fade show"><i class="bi bi-check-circle me-2"></i><?php echo e(session('success')); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php if($errors->any()): ?><div class="alert alert-danger alert-dismissible fade show"><i class="bi bi-exclamation-triangle me-2"></i><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($e); ?><br><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div><?php endif; ?>
    <?php echo $__env->yieldContent('content'); ?>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/layouts/app.blade.php ENDPATH**/ ?>