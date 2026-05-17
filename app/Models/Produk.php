<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Produk extends Model {
    protected $table = 'produk';
    protected $fillable = ['kode','nama','merk','kategori_id','harga_awal','harga_jual','foto','deskripsi','is_active'];
    protected $casts = ['is_active' => 'boolean'];
    public function kategori() { return $this->belongsTo(Kategori::class); }
    public function getFotoUrlAttribute(): string {
        return $this->foto ? asset('uploads/produk/'.$this->foto) : asset('img/no-image.png');
    }
}
