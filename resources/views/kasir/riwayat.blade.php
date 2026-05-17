@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="card">
    <div class="card-header p-3 d-flex align-items-center justify-content-between">
        <span><i class="bi bi-clock-history me-2 text-success"></i>Riwayat Transaksi</span>
        <form class="d-flex gap-2" method="GET">
            <input type="date" name="tanggal" class="form-control form-control-sm" value="{{ request('tanggal', date('Y-m-d')) }}">
            <select name="status" class="form-select form-select-sm" style="width:130px">
                <option value="">Semua Status</option>
                <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="hutang"  {{ request('status') === 'hutang'  ? 'selected' : '' }}>Hutang</option>
                <option value="batal"   {{ request('status') === 'batal'   ? 'selected' : '' }}>Batal</option>
            </select>
            <button class="btn btn-sm btn-success">Filter</button>
        </form>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>No. Transaksi</th>
                    <th>Kasir</th>
                    <th>Pelanggan</th>
                    <th>Metode</th>
                    <th class="text-end">Total</th>
                    <th>Status</th>
                    <th>Waktu</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $t)
                <tr>
                    <td><span class="fw-semibold font-monospace">{{ $t->no_transaksi }}</span></td>
                    <td>{{ $t->user->name }}</td>
                    <td>{{ $t->pelanggan?->nama ?? 'Umum' }}</td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ ucfirst($t->metode_bayar) }}</span>
                    </td>
                    <td class="text-end fw-semibold">Rp {{ number_format($t->total, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td class="text-muted small">{{ $t->created_at->format('H:i') }}</td>
                    <td>
                        <a href="{{ route('kasir.struk', $t->id) }}" target="_blank" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-printer"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted py-4">Tidak ada transaksi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($transaksi->hasPages())
    <div class="card-footer">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>
@endsection
