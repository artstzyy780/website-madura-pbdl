<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['id_staff','name','username','password','role','status','email','telepon','alamat','foto'];
    protected $hidden   = ['password','remember_token'];
    protected function casts(): array { return ['password' => 'hashed']; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function isOnAir(): bool { return $this->status === 'on_air'; }
    public function transaksi() { return $this->hasMany(Transaksi::class); }
}
