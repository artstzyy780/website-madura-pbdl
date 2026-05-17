<?php
namespace App\Http\Controllers;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class ProdukController extends Controller {
    public function index(Kategori $kategori, Request $request) {
        $search = $request->get('q','');
        $produk = Produk::where('kategori_id', $kategori->id)
            ->when($search, fn($q)=>$q->where(fn($q2)=>$q2->where('nama','like',"%{$search}%")->orWhere('kode','like',"%{$search}%")))
            ->where('is_active',true)->get();
        return view('produk.index', compact('kategori','produk','search'));
    }

    public function store(Request $request, Kategori $kategori) {
        $data = $request->validate([
            'kode'       => 'required|unique:produk,kode',
            'nama'       => 'required',
            'merk'       => 'nullable',
            'harga_awal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi'  => 'nullable',
            'foto'       => 'nullable|image|max:2048',
        ]);
        $data['kategori_id'] = $kategori->id;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $data['foto'] = $filename;
        }
        $p = Produk::create($data);
        AuditLog::catat('CREATE','Produk',"Tambah produk: {$p->nama} ({$p->kode})");
        return response()->json(['success'=>true,'produk'=>$p]);
    }

    public function update(Request $request, Produk $produk) {
        $data = $request->validate([
            'kode'       => "required|unique:produk,kode,{$produk->id}",
            'nama'       => 'required',
            'merk'       => 'nullable',
            'harga_awal' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi'  => 'nullable',
            'foto'       => 'nullable|image|max:2048',
        ]);
        if ($request->hasFile('foto')) {
            if ($produk->foto && file_exists(public_path('uploads/produk/'.$produk->foto))) {
                unlink(public_path('uploads/produk/'.$produk->foto));
            }
            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/produk'), $filename);
            $data['foto'] = $filename;
        }
        $produk->update($data);
        AuditLog::catat('UPDATE','Produk',"Edit produk: {$produk->nama}");
        return response()->json(['success'=>true,'produk'=>$produk->fresh()]);
    }

    public function destroy(Produk $produk) {
        $produk->update(['is_active'=>false]);
        AuditLog::catat('DELETE','Produk',"Nonaktifkan produk: {$produk->nama}");
        return response()->json(['success'=>true]);
    }
}
