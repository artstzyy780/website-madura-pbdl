<?php $__env->startSection('title','Kasir'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.kasir-wrap{background:#fff;border-radius:12px;padding:1.25rem;box-shadow:0 2px 8px rgba(0,0,0,.06);}
.tab-buttons{display:flex;gap:.5rem;margin-bottom:1rem;}
.tab-btn{padding:.5rem 1.2rem;border-radius:8px;border:1.5px solid #d1d5db;background:#fff;font-weight:600;font-size:.85rem;cursor:pointer;color:#374151;}
.tab-btn.active{background:#1a2fa0;color:#fff;border-color:#1a2fa0;}
.pesanan-header{background:#b0bec5;border-radius:8px;padding:.75rem 1rem;display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;}
.pesanan-header .no{font-weight:700;font-size:.95rem;}
.pesanan-header .time{font-size:.8rem;color:#374151;}
.field-label{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#374151;margin-bottom:.3rem;}
.input-kode{display:flex;gap:.5rem;align-items:center;}
.autocomplete-container{position:relative;flex:1;}
.autocomplete-container input{width:100%;border:1px solid #d1d5db;border-radius:8px;padding:.55rem .9rem;font-size:.9rem;box-sizing:border-box;}
.autocomplete-dropdown{position:absolute;top:100%;left:0;right:0;background:#fff;border:1px solid #d1d5db;border-radius:8px;z-index:50;max-height:250px;overflow-y:auto;box-shadow:0 4px 12px rgba(0,0,0,.15);display:none;margin-top:4px;}
.autocomplete-item{padding:.5rem .9rem;cursor:pointer;border-bottom:1px solid #f3f4f6;text-align:left;}
.autocomplete-item:last-child{border-bottom:none;}
.autocomplete-item:hover{background:#eff6ff;}
.autocomplete-item .ai-top{display:flex;justify-content:space-between;align-items:center;}
.autocomplete-item .ai-kode{font-weight:700;font-size:.8rem;color:#1a2fa0;}
.autocomplete-item .ai-harga{font-size:.8rem;font-weight:600;color:#059669;}
.autocomplete-item .ai-nama{font-size:.85rem;color:#374151;margin-top:.1rem;}
.hint{font-size:.72rem;color:#9ca3af;margin-top:.25rem;}
.item-table{width:100%;border-collapse:collapse;margin-top:.75rem;}
.item-table th{font-size:.75rem;text-transform:uppercase;letter-spacing:.5px;color:#6b7280;padding:.4rem .6rem;border-bottom:1px solid #e5e7eb;}
.item-table td{padding:.5rem .6rem;border-bottom:1px solid #f3f4f6;font-size:.88rem;vertical-align:middle;}
.qty-ctrl{display:flex;align-items:center;gap:.3rem;}
.qty-btn{width:24px;height:24px;border-radius:6px;border:1px solid #d1d5db;background:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:.9rem;}
.qty-btn:hover{background:#1a2fa0;color:#fff;border-color:#1a2fa0;}
.selesai-box{background:#b0bec5;border-radius:8px;padding:1rem;margin-top:1rem;}
.selesai-box .lbl{font-weight:700;font-size:.9rem;margin-bottom:.5rem;}
.total-input{background:#fff;border:none;border-radius:8px;padding:.55rem 1rem;font-size:.95rem;font-weight:600;width:180px;}
.btn-bayar-main{background:#1a2fa0;color:#fff;border:none;border-radius:8px;padding:.55rem 1.4rem;font-weight:600;margin-top:.75rem;cursor:pointer;}
.btn-bayar-main:disabled{background:#9ca3af;}
.btn-draf{background:#f59e0b;color:#fff;border:none;border-radius:8px;padding:.55rem 1.4rem;font-weight:600;margin-top:.75rem;cursor:pointer;transition:background .15s;}
.btn-draf:hover{background:#d97706;}
.btn-draf:disabled{background:#9ca3af;cursor:not-allowed;}
/* Metode Modal */
.metode-section{background:#374151;color:#fff;border-radius:8px;padding:.5rem 1rem;margin-bottom:.75rem;font-size:.8rem;font-weight:600;}
.metode-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:.5rem;margin-bottom:.75rem;}
.metode-btn{border:1.5px solid #e5e7eb;border-radius:8px;padding:.4rem;text-align:center;cursor:pointer;background:#fff;font-size:.8rem;transition:all .15s;}
.metode-btn:hover,.metode-btn.selected{border-color:#1a2fa0;background:#eff6ff;}
.metode-btn img,.metode-btn span{display:block;}
.metode-tunai{display:grid;grid-template-columns:1fr 1fr;gap:.5rem;}
.metode-tunai .metode-btn{display:flex;align-items:center;justify-content:center;gap:.4rem;padding:.6rem;}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<div class="kasir-wrap">
  <div class="tab-buttons">
    <button class="tab-btn active" id="btnSimpan">SIMPAN PESANAN</button>
    <button class="tab-btn" id="btnDraf" onclick="bukaModalDraf()">DRAF PESANAN</button>
  </div>

  <div class="pesanan-header">
    <span class="no" id="pesananNo">PESANAN KE 1</span>
    <span class="time" id="pesananTime"></span>
  </div>

  <div class="mb-3">
    <div class="field-label">NAMA PEMBELI</div>
    <input type="text" id="namaPembeli" class="form-control" placeholder="[OPSIONAL]">
  </div>

  <div class="mb-1">
    <div class="field-label">CARI BARANG</div>
    <div class="input-kode">
      <div class="autocomplete-container">
        <input type="text" id="inputKode" placeholder="KETIK KODE ATAU NAMA BARANG" autocomplete="off" onkeyup="if(event.key==='Enter') tambahItem(); else cariSaran(this.value)">
        <div id="autocompleteDropdown" class="autocomplete-dropdown"></div>
      </div>
      <button class="btn btn-blue btn-sm px-3" onclick="tambahItem()">+ Tambah</button>
    </div>
    <div class="hint" id="hintKode">Ketik nama barang untuk melihat saran, atau masukkan kode langsung</div>
  </div>

  <table class="item-table">
    <thead>
      <tr>
        <th>KODE BARANG</th>
        <th>HARGA (SATUAN)</th>
        <th>JUMLAH</th>
        <th>TOTAL</th>
        <th></th>
      </tr>
    </thead>
    <tbody id="cartBody">
      <tr id="emptyRow"><td colspan="5" class="text-center text-muted py-3" style="font-size:.85rem">Belum ada item. Masukkan kode barang di atas.</td></tr>
    </tbody>
  </table>

  <div class="selesai-box">
    <div class="lbl">SELESAI</div>
    <div class="d-flex align-items-center gap-3 flex-wrap">
      <div>
        <div style="font-size:.75rem;font-weight:600;margin-bottom:.25rem;">TOTAL BELANJA</div>
        <input type="text" class="total-input" id="totalDisplay" value="Rp0" readonly>
      </div>
      <div class="d-flex gap-2 flex-wrap">
        <button class="btn-draf" id="btnSimpanDraf" disabled onclick="simpanDraf()">
          <i class="bi bi-bookmark-fill me-1"></i>SIMPAN DRAF
        </button>
        <button class="btn-bayar-main" id="btnPilihBayar" disabled onclick="bukaModalBayar()">PILIH PEMBAYARAN</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalBayar" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold w-100 text-center">METODE PEMBAYARAN</h5>
      </div>
      <div class="modal-body pt-2">
        <div class="bg-dark text-white rounded p-2 mb-3 text-center" id="bayarNota" style="font-size:.85rem;"></div>
        <div class="text-center mb-3">
          <div class="d-inline-flex align-items-center gap-1 border rounded px-2 py-1">
            <span class="fw-bold text-muted" style="font-size:.8rem;">Rp</span>
            <span id="bayarTotal" class="fw-bold fs-5">0</span>
          </div>
        </div>

        <div class="metode-section">Pembayaran Non-Tunai</div>
        <div class="metode-grid">
          <div class="metode-btn" onclick="pilihMetode('gopay',this)"><span style="color:#00ae11;font-weight:800;font-size:.9rem;">gopay</span></div>
          <div class="metode-btn" onclick="pilihMetode('dana',this)"><span style="color:#118eea;font-weight:800;font-size:.9rem;">DANA</span></div>
          <div class="metode-btn" onclick="pilihMetode('qris',this)"><span style="color:#e53e3e;font-weight:800;font-size:.9rem;">QRIS</span></div>
          <div class="metode-btn" onclick="pilihMetode('bca',this)"><span style="color:#004f97;font-weight:800;font-size:.9rem;">BCA</span></div>
          <div class="metode-btn" onclick="pilihMetode('seabank',this)"><span style="color:#005fab;font-weight:800;font-size:.9rem;">SeaBank</span></div>
          <div class="metode-btn" onclick="pilihMetode('mandiri',this)"><span style="color:#003d7a;font-weight:800;font-size:.9rem;">mandiri</span></div>
        </div>

        <div class="metode-section">Pembayaran Tunai</div>
        <div class="metode-tunai">
          <div class="metode-btn" onclick="pilihMetode('cash',this)"><i class="bi bi-cash me-1"></i>CASH</div>
          <div class="metode-btn" onclick="pilihMetode('hutang',this)"><i class="bi bi-journal-text me-1"></i>HUTANG</div>
        </div>
        <div id="inputNamaPembeli" class="mt-2" style="display:none;">
          <input type="text" id="namaPembeliHutang" class="form-control form-control-sm" placeholder="Nama pembeli (wajib untuk hutang)">
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button class="btn btn-danger flex-fill" data-bs-dismiss="modal">BATALKAN</button>
        <button class="btn btn-secondary flex-fill" id="btnBayarFinal" onclick="prosesBayar()">BAYAR</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalDraf" tabindex="-1">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title fw-bold">DRAF PESANAN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-2" id="draftList">
        <div class="text-muted text-center py-3">Memuat draf...</div>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalDrafSukses" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow" style="border-radius:16px;">
      <div class="modal-body text-center py-4 px-3">
        <div style="font-size:3rem;margin-bottom:.5rem;">🔖</div>
        <h6 class="fw-bold mb-1">Draf berhasil disimpan!</h6>
        <p class="text-muted small mb-0" id="drafSuksesNama">Pesanan telah disimpan sebagai draf.</p>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
let cart = [];
let metodeBayar = '';
let pesananKe = 1;
let currentDraftId = null;

// Update clock
function updateTime() {
  const now = new Date();
  document.getElementById('pesananTime').textContent =
    now.toLocaleDateString('id-ID',{day:'2-digit',month:'2-digit',year:'numeric'}) + ' ' +
    now.toLocaleTimeString('id-ID',{hour:'2-digit',minute:'2-digit'});
}
setInterval(updateTime, 1000); updateTime();

const formatRp = n => 'Rp' + parseInt(n).toLocaleString('id-ID');

let debounceSaran;
async function cariSaran(q) {
  const dd = document.getElementById('autocompleteDropdown');
  if (!q.trim()) { dd.style.display = 'none'; return; }
  
  clearTimeout(debounceSaran);
  debounceSaran = setTimeout(async () => {
    try {
      const res = await fetch(`/kasir/cari?kode=${encodeURIComponent(q)}`, {headers:{'X-Requested-With':'XMLHttpRequest'}});
      if (!res.ok) { dd.style.display = 'none'; return; }
      const data = await res.json();
      if (!data.length) { dd.style.display = 'none'; return; }
      
      dd.innerHTML = data.map(p => `
        <div class="autocomplete-item" onclick="pilihSaran('${p.kode}', '${p.nama.replace(/'/g, "\\'")}', ${p.harga_jual}, ${p.id})">
          <div class="ai-top">
            <span class="ai-kode">${p.kode}</span>
            <span class="ai-harga">Rp ${parseInt(p.harga_jual).toLocaleString('id-ID')}</span>
          </div>
          <div class="ai-nama">${p.nama}</div>
        </div>
      `).join('');
      dd.style.display = 'block';
    } catch(e) { dd.style.display = 'none'; }
  }, 300);
}

function pilihSaran(kode, nama, harga, id) {
  document.getElementById('inputKode').value = kode;
  document.getElementById('autocompleteDropdown').style.display = 'none';
  tambahItemManual(kode, nama, harga, id);
}

function tambahItemManual(kode, nama, harga, id) {
  const idx = cart.findIndex(i => i.kode === kode);
  if (idx >= 0) { cart[idx].qty++; }
  else { cart.push({id: id, kode: kode, nama: nama, harga: harga, qty: 1}); }

  document.getElementById('inputKode').value = '';
  const hint = document.getElementById('hintKode');
  hint.textContent = `✅ ${nama} ditambahkan`;
  hint.style.color = '#059669';
  renderCart();
}

async function tambahItem() {
  const kode = document.getElementById('inputKode').value.trim();
  if (!kode) return;
  const hint = document.getElementById('hintKode');

  try {
    const res  = await fetch(`/kasir/cari?kode=${encodeURIComponent(kode)}`, {headers:{'X-Requested-With':'XMLHttpRequest'}});
    const data = await res.json();
    if (!res.ok || !data.length) { hint.textContent = '❌ Produk tidak ditemukan'; hint.style.color='#dc2626'; return; }

    const p = data[0]; // Ambil produk pertama dari hasil
    tambahItemManual(p.kode, p.nama, p.harga_jual, p.id);
    document.getElementById('autocompleteDropdown').style.display = 'none';
  } catch(e) {
    hint.textContent = '❌ Gagal: ' + e.message; hint.style.color = '#dc2626';
  }
}

document.addEventListener('click', function(e) {
  if (!e.target.closest('.input-kode')) {
    const dd = document.getElementById('autocompleteDropdown');
    if(dd) dd.style.display = 'none';
  }
});

function renderCart() {
  const tbody = document.getElementById('cartBody');
  const isEmpty = !cart.length;
  document.getElementById('btnSimpanDraf').disabled = isEmpty;
  if (isEmpty) {
    tbody.innerHTML = '<tr id="emptyRow"><td colspan="5" class="text-center text-muted py-3" style="font-size:.85rem">Belum ada item.</td></tr>';
    document.getElementById('totalDisplay').value = 'Rp0';
    document.getElementById('btnPilihBayar').disabled = true;
    return;
  }
  let total = 0;
  tbody.innerHTML = cart.map((item,i) => {
    const sub = item.harga * item.qty; total += sub;
    return `<tr>
      <td class="fw-semibold">${item.kode}</td>
      <td>Rp. ${parseInt(item.harga).toLocaleString('id-ID')}</td>
      <td><div class="qty-ctrl">
        <button class="qty-btn" onclick="changeQty(${i},-1)">−</button>
        <span style="min-width:24px;text-align:center">${item.qty}</span>
        <button class="qty-btn" onclick="changeQty(${i},1)">+</button>
      </div></td>
      <td class="fw-semibold">${formatRp(sub)}</td>
      <td>
        <button class="btn btn-sm btn-outline-primary py-0 me-1" onclick="editItem(${i})"><i class="bi bi-pencil"></i></button>
        <button class="btn btn-sm btn-outline-danger py-0" onclick="hapusItem(${i})"><i class="bi bi-trash"></i></button>
      </td>
    </tr>`;
  }).join('');
  document.getElementById('totalDisplay').value = formatRp(total);
  document.getElementById('btnPilihBayar').disabled = false;
}

function changeQty(i, delta) {
  cart[i].qty = Math.max(1, cart[i].qty + delta);
  renderCart();
}
function hapusItem(i) { cart.splice(i,1); renderCart(); }
function editItem(i) {
  const item = cart[i];
  const qty = prompt(`Edit jumlah untuk ${item.nama}:`, item.qty);
  if (qty && parseInt(qty) > 0) { cart[i].qty = parseInt(qty); renderCart(); }
}

let metodeTerpilih = '';
function pilihMetode(m, el) {
  document.querySelectorAll('.metode-btn').forEach(b => b.classList.remove('selected'));
  el.classList.add('selected');
  metodeTerpilih = m;
  document.getElementById('inputNamaPembeli').style.display = m === 'hutang' ? 'block' : 'none';
}

function bukaModalBayar() {
  const total = cart.reduce((s,i) => s+i.harga*i.qty, 0);
  const noNota = `Pembayaran Ke-${pesananKe}`;
  document.getElementById('bayarNota').textContent = noNota;
  document.getElementById('bayarTotal').textContent = parseInt(total).toLocaleString('id-ID') + ',00';
  metodeTerpilih = '';
  document.querySelectorAll('.metode-btn').forEach(b => b.classList.remove('selected'));
  new bootstrap.Modal(document.getElementById('modalBayar')).show();
}

async function prosesBayar() {
  if (!metodeTerpilih) { alert('Pilih metode pembayaran!'); return; }
  const namaPembeli = document.getElementById('namaPembeli').value ||
    (metodeTerpilih === 'hutang' ? document.getElementById('namaPembeliHutang').value : '');
  if (metodeTerpilih === 'hutang' && !namaPembeli) { alert('Nama pembeli wajib diisi untuk hutang!'); return; }

  const btn = document.getElementById('btnBayarFinal');
  btn.disabled = true; btn.textContent = 'Memproses...';
  try {
    const res = await fetch('/kasir/simpan', {
      method:'POST',
      headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content},
      body:JSON.stringify({items:cart.map(i=>({kode:i.kode,qty:i.qty})),metode_bayar:metodeTerpilih,nama_pembeli:namaPembeli,draft_id:currentDraftId})
    });
    const data = await res.json();
    if (!res.ok) { alert(data.error||'Gagal'); return; }

    bootstrap.Modal.getInstance(document.getElementById('modalBayar'))?.hide();
    pesananKe++;
    document.getElementById('pesananNo').textContent = `PESANAN KE ${pesananKe}`;
    cart = []; currentDraftId = null;
    document.getElementById('namaPembeli').value = '';
    renderCart();
    window.open(`/kasir/struk/${data.transaksi_id}`,'_blank');
  } catch(e) { alert('Error: '+e.message); }
  finally { btn.disabled = false; btn.textContent = 'BAYAR'; }
}

async function bukaModalDraf() {
  const modal = new bootstrap.Modal(document.getElementById('modalDraf'));
  modal.show();
  const el = document.getElementById('draftList');
  el.innerHTML = '<div class="text-muted text-center py-3"><i class="bi bi-hourglass-split me-1"></i>Memuat draf...</div>';

  try {
    const res = await fetch('/kasir/drafts', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
    const drafts = await res.json();

    if (!drafts.length) {
      el.innerHTML = '<div class="text-muted text-center py-3">Tidak ada draf tersimpan</div>';
      return;
    }

    const formatRpList = n => 'Rp ' + parseInt(n).toLocaleString('id-ID');
    el.innerHTML = drafts.map(d => `
      <div class="d-flex align-items-center justify-content-between p-2 border-bottom">
        <div style="cursor:pointer;flex:1" onclick="loadDraft(${d.id})">
          <div class="fw-semibold">${d.nama_pembeli || 'Tanpa Nama'}</div>
          <div class="text-muted" style="font-size:.78rem;">${formatRpList(d.total)}</div>
        </div>
        <button class="btn btn-sm btn-outline-danger py-0 ms-2" onclick="hapusDraft(${d.id}, this)"><i class="bi bi-trash"></i></button>
      </div>
    `).join('');
  } catch(e) {
    el.innerHTML = '<div class="text-danger text-center py-3">Gagal memuat draf.</div>';
  }
}

async function loadDraft(id, nama) {
  const res = await fetch(`/kasir/draft/${id}`);
  const data = await res.json();
  cart = data.items.map(i => ({id:i.produk_id,kode:i.kode_barang,nama:i.nama_produk,harga:i.harga,qty:i.qty}));
  currentDraftId = id;
  document.getElementById('namaPembeli').value = data.nama_pembeli||'';
  renderCart();
  bootstrap.Modal.getInstance(document.getElementById('modalDraf'))?.hide();
}

async function hapusDraft(id, btn) {
  await fetch(`/kasir/draft/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}});
  btn.closest('.d-flex').remove();
}

async function simpanDraf() {
  if (!cart.length) return;
  const btn = document.getElementById('btnSimpanDraf');
  btn.disabled = true;
  btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Menyimpan...';

  const nama = document.getElementById('namaPembeli').value.trim() || 'Tanpa Nama';
  try {
    const res = await fetch('/kasir/draft', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify({
        items: cart.map(i => ({ kode: i.kode, qty: i.qty })),
        nama_pembeli: nama,
        draft_id: currentDraftId
      })
    });
    const data = await res.json();
    if (!res.ok) { alert(data.error || 'Gagal menyimpan draf'); return; }

    currentDraftId = data.draft_id;

    // Tampilkan modal sukses
    document.getElementById('drafSuksesNama').textContent =
      `Draf untuk "${data.nama}" berhasil disimpan.`;
    const modalSukses = new bootstrap.Modal(document.getElementById('modalDrafSukses'));
    modalSukses.show();

    // Reset pesanan setelah 1.5 detik
    setTimeout(() => {
      modalSukses.hide();
      // Bersihkan form untuk pelanggan berikutnya
      cart = [];
      currentDraftId = null;
      document.getElementById('namaPembeli').value = '';
      pesananKe++;
      document.getElementById('pesananNo').textContent = `PESANAN KE ${pesananKe}`;
      renderCart();
    }, 1500);

  } catch(e) {
    alert('Error: ' + e.message);
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-bookmark-fill me-1"></i>SIMPAN DRAF';
  }
}

// Auto-init focus
document.getElementById('inputKode').focus();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\MyBook Hype AMD\OneDrive\Dokumen\kuliah\smt4\database lanjutan\toko madura\toko-madura\resources\views/kasir/index.blade.php ENDPATH**/ ?>