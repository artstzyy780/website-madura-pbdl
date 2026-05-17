@extends('layouts.app')
@section('title', 'Kelola User')
@section('page-title', 'Kelola User')

@section('content')
<div class="d-flex justify-content-end mb-3">
    <a href="{{ route('settings.users.create') }}" class="btn btn-success btn-sm">
        <i class="bi bi-person-plus me-1"></i>Tambah User
    </a>
</div>
<div class="card">
    <div class="card-header p-3"><i class="bi bi-people me-2 text-success"></i>Daftar User</div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $u)
                <tr>
                    <td class="fw-semibold">{{ $u->name }}</td>
                    <td class="font-monospace">{{ $u->username }}</td>
                    <td>
                        <span class="badge {{ $u->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </td>
                    <td>
                        @if($u->is_active)
                            <span class="badge bg-success-subtle text-success">Aktif</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $u->created_at->format('d/m/Y') }}</td>
                    <td class="text-center">
                        @if($u->id !== auth()->id())
                        <form action="{{ route('settings.users.toggle', $u) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $u->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}">
                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
