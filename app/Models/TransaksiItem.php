<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TransaksiItem extends Model {
    protected $table = 'transaksi_item';
    protected $fillable = ['transaksi_id','produk_id','kode_barang','nama_produk','qty','harga','subtotal'];
    public function transaksi() { return $this->belongsTo(Transaksi::class); }
    public function produk()    { return $this->belongsTo(Produk::class); }
}
