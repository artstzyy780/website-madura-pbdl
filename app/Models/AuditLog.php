<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class AuditLog extends Model {
    protected $table = 'audit_log';
    protected $fillable = ['user_id','aksi','entitas','detail','ip_address'];
    public function user() { return $this->belongsTo(User::class); }
    public static function catat(string $aksi, string $entitas = '', string $detail = ''): void {
        static::create([
            'user_id'    => auth()->id(),
            'aksi'       => $aksi,
            'entitas'    => $entitas,
            'detail'     => $detail,
            'ip_address' => request()->ip(),
        ]);
    }
}
