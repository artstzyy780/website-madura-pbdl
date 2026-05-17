<?php
namespace App\Http\Controllers;
use App\Models\Kategori;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    public function index(Request $request) {
        $search = $request->get('q','');
        $kategori = Kategori::withCount('produk')
            ->when($search, fn($q) => $q->where('nama','like',"%{$search}%"))
            ->get();
        return view('kategori.index', compact('kategori','search'));
    }

    public function store(Request $request) {
        $data = $request->validate(['nama'=>'required|unique:kategori,nama','deskripsi'=>'nullable','warna'=>'nullable','icon'=>'nullable']);
        $k = Kategori::create($data);
        AuditLog::catat('CREATE','Kategori',"Tambah kategori: {$k->nama}");
        return response()->json($k);
    }

    public function update(Request $request, Kategori $kategori) {
        $data = $request->validate(['nama'=>"required|unique:kategori,nama,{$kategori->id}",'deskripsi'=>'nullable','warna'=>'nullable','icon'=>'nullable']);
        $kategori->update($data);
        return response()->json($kategori);
    }

    public function destroy(Kategori $kategori) {
        $kategori->delete();
        AuditLog::catat('DELETE','Kategori',"Hapus kategori: {$kategori->nama}");
        return response()->json(['success'=>true]);
    }
}
