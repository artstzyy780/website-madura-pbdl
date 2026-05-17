<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog;

class AuthController extends Controller {
    public function showLogin() { return view('auth.login'); }

    public function login(Request $request) {
        $request->validate(['username'=>'required','password'=>'required'],
            ['username.required'=>'Username wajib diisi','password.required'=>'Password wajib diisi']);

        if (Auth::attempt($request->only('username','password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            if (Auth::user()->status === 'libur') {
                Auth::logout();
                return back()->withErrors(['username' => 'Akun Anda sedang dalam status Libur.']);
            }
            AuditLog::catat('LOGIN', 'System', 'User login ke sistem');
            $home = auth()->user()->role === 'admin'
                ? route('dashboard')
                : route('kasir.index');
            return redirect()->intended($home);
        }
        return back()->withErrors(['username' => 'Username atau password salah.'])->withInput($request->only('username'));
    }

    public function logout(Request $request) {
        AuditLog::catat('LOGOUT', 'System', 'User logout dari sistem');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
