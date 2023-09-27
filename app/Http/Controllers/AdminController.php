<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use App\Models\Telnet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $title = 'Profil | Jenius';
        $activeLink = 'settings';
        return view('admin.profiles.index', compact('title', 'activeLink'));
    }

    public function update(Request $request)
    {

        if ($request->password != null) {
            $requestValidate = $request->validate([
                'name' => 'required',
                'password' => 'required|min:8',
            ]);
            $requestValidate['password'] = Hash::make($request->password);
        } else {
            $requestValidate = $request->validate([
                'name' => 'required',
            ]);
        }
        User::find(Auth::user()->id)->update($requestValidate);
        return redirect('/admin/profile')->with('success', 'Berhasil mengubah akun');
    }
}
