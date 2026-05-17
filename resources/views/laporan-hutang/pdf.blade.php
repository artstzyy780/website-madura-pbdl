<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Laporan {{ $dari }} - {{ $sampai }}</title>
<style>
body{font-family:Arial,sans-serif;font-size:12px;margin:20px;}
h2{text-align:center;margin-bottom:4px;}
p{text-align:center;color:#666;margin-bottom:16px;}
table{width:100%;border-collapse:collapse;}
th{background:#1a2fa0;color:#fff;padding:6px 8px;text-align:left;}
td{padding:5px 8px;border-bottom:1px solid #eee;}
.summary{display:flex;gap:20px;margin-top:16px;}
.box{padding:10px 16px;border-radius:8px;flex:1;}
.box.hutang{background:#fee2e2;color:#991b1b;}
.box.lunas{background:#d1fae5;color:#065f46;}
@media print{@page{margin:15mm;}}
</style>
</head>
<body>
<h2>Laporan Transaksi</h2>
<p>Periode: {{ $dari }} s/d {{ $sampai }}</p>
<table>
  <thead><tr><th>Tanggal</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead>
  <tbody>
    @foreach($transaksi as $t)
    <tr>
      <td>{{ $t->created_at->format('d/m/Y') }}</td>
      <td>{{ $t->nama_pembeli ?: '-' }}</td>
      <td>Rp {{ number_format($t->total,0,',','.') }}</td>
      <td>{{ ucfirst($t->status) }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
<div style="display:flex;gap:16px;margin-top:16px;">
  <div style="background:#fee2e2;padding:10px 16px;border-radius:8px;flex:1;">
    <div style="color:#991b1b;font-weight:bold;">Total Hutang: Rp {{ number_format($totalHutang,0,',','.') }}</div>
  </div>
  <div style="background:#d1fae5;padding:10px 16px;border-radius:8px;flex:1;">
    <div style="color:#065f46;font-weight:bold;">Total Lunas: Rp {{ number_format($totalLunas,0,',','.') }}</div>
  </div>
</div>
<script>window.onload = () => window.print();</script>
</body>
</html>
