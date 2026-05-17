<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaksi extends Model {
    protected $table = 'transaksi';
    protected $fillable = ['no_nota','user_id','nama_pembeli','pelanggan_id','metode_bayar','total','status','is_draft','catatan'];
    protected $casts = ['is_draft' => 'boolean'];
    public function user()      { return $this->belongsTo(User::class); }
    public function pelanggan() { return $this->belongsTo(Pelanggan::class); }
    public function items()     { return $this->hasMany(TransaksiItem::class); }
}
