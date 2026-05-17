<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\TokoSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller {
    public function index() {
        $user = auth()->user();
        $toko = TokoSetting::first();
        return view('settings.index', compact('user','toko'));
    }

    public function updateProfile(Request $request) {
        $user = auth()->user();
        $data = $request->validate(['name'=>'required','email'=>'nullable|email','telepon'=>'nullable','alamat'=>'nullable']);
        if ($request->hasFile('foto')) {
            if ($user->foto && file_exists(public_path('uploads/user/'.$user->foto))) unlink(public_path('uploads/user/'.$user->foto));
            $f = $request->file('foto');
            $fn = time().'_'.$f->getClientOriginalName();
            $f->move(public_path('uploads/user'), $fn);
            $data['foto'] = $fn;
        }
        $user->update($data);
        return back()->with('success','Profil berhasil diperbarui');
    }

    public function updateToko(Request $request) {
        $data = $request->validate(['nama_toko'=>'required','alamat'=>'nullable']);
        if ($request->hasFile('logo')) {
            $f = $request->file('logo');
            $fn = time().'_'.$f->getClientOriginalName();
            $f->move(public_path('uploads/toko'), $fn);
            $data['logo'] = $fn;
        }
        TokoSetting::first()->update($data);
        return back()->with('success','Info toko berhasil diperbarui');
    }
}
