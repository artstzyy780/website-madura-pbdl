<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pelanggan extends Model {
    protected $table = 'pelanggan';
    protected $fillable = ['nama','telepon','alamat','saldo_hutang'];
    public function transaksi() { return $this->hasMany(Transaksi::class); }
}
