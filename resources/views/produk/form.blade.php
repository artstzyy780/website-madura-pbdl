@extends('layouts.app')
@section('title', isset($produk) ? 'Edit Produk' : 'Tambah Produk')
@section('page-title', isset($produk) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
<div class="row justify-content-center">
<div class="col-lg-8">
<div class="card">
    <div class="card-header p-3">
        <i class="bi bi-box-seam me-2 text-success"></i>
        {{ isset($produk) ? 'Edit Produk: ' . $produk->nama : 'Tambah Produk Baru' }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ isset($produk) ? route('produk.update', $produk) : route('produk.store') }}">
            @csrf
            @if(isset($produk)) @method('PUT') @endif

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Kode Produk <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror"
                        value="{{ old('kode', $produk->kode ?? '') }}" required>
                    @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8">
                    <label class="form-label fw-semibold">Nama Produk <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama', $produk->nama ?? '') }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select name="kategori_id" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id', $produk->kategori_id ?? '') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Satuan <span class="text-danger">*</span></label>
                    <input type="text" name="satuan" class="form-control"
                        value="{{ old('satuan', $produk->satuan ?? 'pcs') }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Barcode</label>
                    <input type="text" name="barcode" class="form-control font-monospace"
                        value="{{ old('barcode', $produk->barcode ?? '') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga Beli (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_beli" class="form-control @error('harga_beli') is-invalid @enderror"
                        value="{{ old('harga_beli', $produk->harga_beli ?? 0) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="harga_jual" class="form-control @error('harga_jual') is-invalid @enderror"
                        value="{{ old('harga_jual', $produk->harga_jual ?? 0) }}" min="0" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stok Awal</label>
                    <input type="number" name="stok" class="form-control"
                        value="{{ old('stok', $produk->stok ?? 0) }}" min="0">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Stok Minimal</label>
                    <input type="number" name="stok_minimal" class="form-control"
                        value="{{ old('stok_minimal', $produk->stok_minimal ?? 5) }}" min="0">
                    <small class="text-muted">Alert jika stok ≤ nilai ini</small>
                </div>
                @if(isset($produk))
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" {{ $produk->is_active ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$produk->is_active ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
                @endif
                <div class="col-12">
                    <label class="form-label fw-semibold">Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="2">{{ old('keterangan', $produk->keterangan ?? '') }}</textarea>
                </div>
            </div>

            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check2 me-1"></i>{{ isset($produk) ? 'Perbarui' : 'Simpan' }}
                </button>
                <a href="{{ route('produk.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
</div>
</div>
@endsection
