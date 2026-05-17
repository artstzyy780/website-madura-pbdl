<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TokoSetting extends Model {
    protected $table = 'toko_settings';
    protected $fillable = ['nama_toko','alamat','logo'];
}
