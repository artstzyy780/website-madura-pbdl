<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Login - Madura's Store</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">
<style>
body{margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;font-family:'Segoe UI',sans-serif;background:url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?w=1200&q=80') center/cover no-repeat;position:relative;}
body::before{content:'';position:absolute;inset:0;background:rgba(10,20,80,.45);}
.login-box{position:relative;background:#fff;border-radius:16px;padding:2.5rem;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.4);}
.login-header{background:#1a2fa0;text-align:center;padding:1rem;border-radius:10px;margin-bottom:1.5rem;}
.login-header h2{color:#fff;font-weight:700;font-size:1.5rem;margin:0;letter-spacing:2px;}
.form-label{font-size:.8rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#374151;}
.form-control{border-radius:8px;background:#fdba74;border:none;color:#1f2937;font-weight:500;padding:.65rem 1rem;}
.form-control::placeholder{color:rgba(31,41,55,.6);}
.form-control:focus{background:#fed7aa;box-shadow:0 0 0 3px rgba(249,115,22,.3);border:none;}
.btn-login{background:#1a2fa0;color:#fff;border:none;border-radius:8px;padding:.75rem 2rem;font-weight:700;font-size:1rem;transition:background .2s;}
.btn-login:hover{background:#111e78;color:#fff;}
</style>
</head>
<body>
<div class="login-box">
  <div class="login-header"><h2>WELCOME</h2></div>
  @if($errors->any())
    <div class="alert alert-danger py-2 small mb-3"><i class="bi bi-exclamation-circle me-1"></i>{{ $errors->first() }}</div>
  @endif
  <form action="{{ route('login') }}" method="POST">
    @csrf
    <div class="mb-3">
      <label class="form-label">USERNAME</label>
      <input type="text" name="username" class="form-control" placeholder="input username" value="{{ old('username') }}" autofocus>
    </div>
    <div class="mb-4">
      <label class="form-label">PASSWORD</label>
      <input type="password" name="password" class="form-control" placeholder="input password">
    </div>
    <div class="d-flex justify-content-end">
      <button type="submit" class="btn btn-login">LOGIN &nbsp;<i class="bi bi-box-arrow-in-right"></i></button>
    </div>
  </form>
</div>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</body>
</html>
