@extends('layouts.app')
@section('title', 'Audit Log')
@section('page-title', 'Audit Log')

@section('content')
<div class="card">
    <div class="card-header p-3">
        <i class="bi bi-shield-check me-2 text-success"></i>Jejak Aktivitas Sistem
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Data</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="text-muted small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td class="fw-semibold small">{{ $log->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{
                            str_contains($log->aksi, 'CREATE') ? 'bg-success' :
                            (str_contains($log->aksi, 'DELETE') ? 'bg-danger' :
                            (str_contains($log->aksi, 'UPDATE') ? 'bg-primary' : 'bg-secondary'))
                        }}">{{ $log->aksi }}</span>
                        <span class="text-muted small ms-1">{{ $log->model }}#{{ $log->model_id }}</span>
                    </td>
                    <td>
                        @if($log->data_baru)
                            <button class="btn btn-sm btn-outline-secondary py-0"
                                onclick="showDetail({{ json_encode($log->data_baru) }})">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        @endif
                    </td>
                    <td class="text-muted small font-monospace">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Tidak ada log</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <pre id="detailContent" class="bg-light p-3 rounded small" style="max-height:400px;overflow:auto;white-space:pre-wrap;"></pre>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showDetail(data) {
    document.getElementById('detailContent').textContent = JSON.stringify(data, null, 2);
    new bootstrap.Modal(document.getElementById('modalDetail')).show();
}
</script>
@endpush
