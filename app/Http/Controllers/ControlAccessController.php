<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ControlAccessController extends Controller {
    public function index() {
        $users = User::orderBy('id_staff')->get();
        return view('control-access.index', compact('users'));
    }

    public function store(Request $request) {
        $data = $request->validate([
            'id_staff' => 'required|unique:users,id_staff',
            'name'     => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,kasir,gudang,supervisor',
            'status'   => 'required|in:on_air,libur',
        ]);
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        AuditLog::catat('CREATE','User',"Tambah karyawan: {$user->name} ({$user->id_staff})");
        return response()->json(['success'=>true,'user'=>$user]);
    }

    public function update(Request $request, User $user) {
        $data = $request->validate([
            'name'     => 'required',
            'username' => "required|unique:users,username,{$user->id}",
            'role'     => 'required|in:admin,kasir,gudang,supervisor',
            'status'   => 'required|in:on_air,libur',
        ]);
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        AuditLog::catat('UPDATE','User',"Edit karyawan: {$user->name}");
        return response()->json(['success'=>true,'user'=>$user->fresh()]);
    }

    public function destroy(User $user) {
        if ($user->id === auth()->id()) return response()->json(['error'=>'Tidak bisa hapus akun sendiri'],422);
        AuditLog::catat('DELETE','User',"Hapus karyawan: {$user->name}");
        $user->delete();
        return response()->json(['success'=>true]);
    }

    public function auditLog() {
        $logs = AuditLog::with('user')->orderByDesc('created_at')->limit(200)->get();
        return response()->json($logs);
    }

    public function hapusSemuaLog() {
        AuditLog::truncate();
        AuditLog::catat('DELETE','AuditLog','Hapus semua log audit');
        return response()->json(['success'=>true]);
    }
}
