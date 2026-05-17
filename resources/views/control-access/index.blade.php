@extends('layouts.app')
@section('title','Control Access')
@section('content')
<div class="d-flex gap-2 mb-3">
  <button class="btn btn-sm btn-outline-primary" onclick="bukaModalTambah()">
    <i class="bi bi-plus-circle me-1"></i>Tambah Karyawan
  </button>
  <button class="btn btn-sm btn-outline-secondary" onclick="bukaAudit()">
    <i class="bi bi-file-text me-1"></i>Lihat Jejak Audit
  </button>
</div>

<div class="card">
  <div class="card-body p-0">
    <table class="table table-hover mb-0">
      <thead>
        <tr style="background:#ef4444;">
          <th style="color:#111;border:none;">ID_STAFF</th>
          <th style="color:#111;border:none;">USERNAME</th>
          <th style="color:#111;border:none;">STATUS</th>
          <th style="color:#111;border:none;">ROLE</th>
          <th style="color:#111;border:none;">PASSWORD</th>
          <th style="color:#111;border:none;"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $u)
        <tr>
          <td class="fw-semibold font-monospace">{{ $u->id_staff }}</td>
          <td>{{ $u->name }}</td>
          <td>
            <span class="badge-{{ $u->status === 'on_air' ? 'on-air' : 'libur' }}">
              {{ $u->status === 'on_air' ? 'On Air' : 'Libur' }}
            </span>
          </td>
          <td>{{ ucfirst($u->role) }}</td>
          <td class="font-monospace text-muted">••••••••</td>
          <td>
            <button class="btn btn-sm btn-outline-primary py-0 me-1" onclick='editUser({{ json_encode($u) }})'><i class="bi bi-pencil"></i></button>
            @if($u->id !== auth()->id())
            <button class="btn btn-sm btn-outline-danger py-0" onclick="hapusUser({{ $u->id }}, '{{ $u->name }}')"><i class="bi bi-trash"></i></button>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

{{-- Modal Tambah Karyawan --}}
<div class="modal fade" id="modalUser" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="modalUserTitle">Tambah Karyawan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" style="background-color:#ef4444;border-radius:50%;opacity:1;"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label class="form-label small fw-semibold">ID STAFF</label>
          <input type="text" id="fIdStaff" class="form-control" placeholder="contoh: KSR_2">
        </div>
        <div class="mb-3">
          <label class="form-label small fw-semibold">USERNAME</label>
          <input type="text" id="fUsername" class="form-control" placeholder="Nama karyawan">
        </div>
        <div class="mb-3">
          <label class="form-label small fw-semibold">PASSWORD</label>
          <div class="input-group">
            <input type="password" id="fPassword" class="form-control" placeholder="Password">
            <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()"><i class="bi bi-eye" id="eyeIcon"></i></button>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label small fw-semibold">STATUS</label>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-success flex-fill status-btn active" onclick="setStatus('on_air',this)">On Air</button>
            <button type="button" class="btn btn-outline-secondary flex-fill status-btn" onclick="setStatus('libur',this)">Libur</button>
          </div>
          <input type="hidden" id="fStatus" value="on_air">
        </div>
        <div class="mb-0">
          <label class="form-label small fw-semibold">ROLE</label>
          <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-outline-secondary flex-fill role-btn" onclick="setRole('admin',this)">Admin</button>
            <button type="button" class="btn btn-primary flex-fill role-btn" onclick="setRole('kasir',this)">Kasir</button>
          </div>
          <input type="hidden" id="fRole" value="kasir">
        </div>
      </div>
      <div class="modal-footer border-0">
        <input type="hidden" id="editUserId" value="">
        <button class="btn btn-danger rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-success rounded-pill px-4" onclick="simpanUser()"><i class="bi bi-floppy me-1"></i>Simpan</button>
      </div>
    </div>
  </div>
</div>

{{-- Modal Jejak Audit --}}
<div class="modal fade" id="modalAudit" tabindex="-1" style="z-index:2000;">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">Jejak Audit Sistem</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <button class="btn btn-danger btn-sm mb-3" onclick="hapusSemuaLog()"><i class="bi bi-trash me-1"></i>Hapus semua log</button>
        <div class="small fw-semibold text-muted mb-2">Semua log</div>
        <table class="table table-sm">
          <thead style="background:#f97316;">
            <tr>
              <th style="color:#111;">Waktu</th>
              <th style="color:#111;">User</th>
              <th style="color:#111;">Aksi</th>
              <th style="color:#111;">Entitas</th>
              <th style="color:#111;">Detail</th>
            </tr>
          </thead>
          <tbody id="auditBody">
            <tr><td colspan="5" class="text-center text-muted py-3">Memuat log...</td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

{{-- Form Delete (hidden) --}}
<form id="formDelete" method="POST" style="display:none;">@csrf @method('DELETE')</form>
@endsection

@push('scripts')
<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// --- Tambah/Edit User ---
function bukaModalTambah() {
  document.getElementById('modalUserTitle').textContent = 'Tambah Karyawan';
  document.getElementById('editUserId').value = '';
  document.getElementById('fIdStaff').value = '';
  document.getElementById('fIdStaff').disabled = false;
  document.getElementById('fUsername').value = '';
  document.getElementById('fPassword').value = '';
  setStatus('on_air', document.querySelector('.status-btn'));
  setRole('kasir', document.querySelectorAll('.role-btn')[1]);
  new bootstrap.Modal(document.getElementById('modalUser')).show();
}

function editUser(u) {
  document.getElementById('modalUserTitle').textContent = 'Edit Karyawan';
  document.getElementById('editUserId').value = u.id;
  document.getElementById('fIdStaff').value   = u.id_staff;
  document.getElementById('fIdStaff').disabled = true;
  document.getElementById('fUsername').value  = u.name;
  document.getElementById('fPassword').value  = '';
  // Set status
  document.querySelectorAll('.status-btn').forEach(b => b.className = 'btn btn-outline-secondary flex-fill status-btn');
  document.getElementById('fStatus').value = u.status;
  const sBtn = u.status === 'on_air' ? document.querySelectorAll('.status-btn')[0] : document.querySelectorAll('.status-btn')[1];
  sBtn.className = 'btn btn-success flex-fill status-btn';
  // Set role
  const roles = ['admin','kasir'];
  document.querySelectorAll('.role-btn').forEach((b,i) => {
    b.className = roles[i] === u.role ? 'btn btn-primary flex-fill role-btn' : 'btn btn-outline-secondary flex-fill role-btn';
  });
  document.getElementById('fRole').value = u.role;
  new bootstrap.Modal(document.getElementById('modalUser')).show();
}

function setStatus(val, el) {
  document.querySelectorAll('.status-btn').forEach(b => b.className = 'btn btn-outline-secondary flex-fill status-btn');
  el.className = 'btn btn-success flex-fill status-btn';
  document.getElementById('fStatus').value = val;
}

function setRole(val, el) {
  document.querySelectorAll('.role-btn').forEach(b => b.className = 'btn btn-outline-secondary flex-fill role-btn');
  el.className = 'btn btn-primary flex-fill role-btn';
  document.getElementById('fRole').value = val;
}

function togglePwd() {
  const input = document.getElementById('fPassword');
  const icon  = document.getElementById('eyeIcon');
  input.type  = input.type === 'password' ? 'text' : 'password';
  icon.className = input.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
}

async function simpanUser() {
  const id       = document.getElementById('editUserId').value;
  const id_staff = document.getElementById('fIdStaff').value;
  const name     = document.getElementById('fUsername').value;
  const password = document.getElementById('fPassword').value;
  const status   = document.getElementById('fStatus').value;
  const role     = document.getElementById('fRole').value;

  if (!name) { alert('Username wajib diisi!'); return; }
  if (!id && !id_staff) { alert('ID Staff wajib diisi!'); return; }
  if (!id && !password) { alert('Password wajib diisi!'); return; }

  const url    = id ? `/control-access/${id}` : '/control-access';
  const method = id ? 'PUT' : 'POST';
  const body   = {name, status, role};
  if (!id) { body.id_staff = id_staff; body.username = name; }
  if (password) body.password = password;

  const res = await fetch(url, {
    method, headers:{'Content-Type':'application/json','X-CSRF-TOKEN':CSRF},
    body: JSON.stringify(body)
  });
  if (res.ok) { window.location.reload(); }
  else { const d = await res.json(); alert(d.message || JSON.stringify(d.errors) || 'Gagal'); }
}

async function hapusUser(id, nama) {
  if (!confirm(`Hapus karyawan ${nama}?`)) return;
  const res = await fetch(`/control-access/${id}`, {
    method:'DELETE', headers:{'X-CSRF-TOKEN':CSRF}
  });
  if (res.ok) window.location.reload();
  else alert('Gagal menghapus');
}

// --- Audit Log ---
async function bukaAudit() {
  new bootstrap.Modal(document.getElementById('modalAudit')).show();
  const res  = await fetch('/control-access/audit-log');
  const logs = await res.json();
  const badgeMap = {
    LOGIN:'<span style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:4px;font-size:.75rem;">LOGIN</span>',
    LOGOUT:'<span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:4px;font-size:.75rem;">LOGOUT</span>',
    EXPORT:'<span style="background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:4px;font-size:.75rem;">EXPORT</span>',
    FILTER:'<span style="background:#fef3c7;color:#92400e;padding:2px 8px;border-radius:4px;font-size:.75rem;">FILTER</span>',
    CREATE:'<span style="background:#d1fae5;color:#065f46;padding:2px 8px;border-radius:4px;font-size:.75rem;">CREATE</span>',
    UPDATE:'<span style="background:#dbeafe;color:#1e40af;padding:2px 8px;border-radius:4px;font-size:.75rem;">UPDATE</span>',
    DELETE:'<span style="background:#fee2e2;color:#991b1b;padding:2px 8px;border-radius:4px;font-size:.75rem;">DELETE</span>',
  };
  document.getElementById('auditBody').innerHTML = logs.length
    ? logs.map(l => `<tr>
        <td class="small text-muted">${new Date(l.created_at).toLocaleString('id-ID')}</td>
        <td class="fw-semibold">${l.user?.name||'-'}</td>
        <td>${badgeMap[l.aksi]||l.aksi}</td>
        <td>${l.entitas||'-'}</td>
        <td class="small text-muted">${l.detail||'-'}</td>
      </tr>`).join('')
    : '<tr><td colspan="5" class="text-center text-muted py-3">Tidak ada log</td></tr>';
}

async function hapusSemuaLog() {
  if (!confirm('Hapus semua log audit?')) return;
  const res = await fetch('/control-access/audit-log/clear', {method:'DELETE',headers:{'X-CSRF-TOKEN':CSRF}});
  if (res.ok) document.getElementById('auditBody').innerHTML = '<tr><td colspan="5" class="text-center text-muted py-3">Log berhasil dihapus</td></tr>';
}
</script>
@endpush
