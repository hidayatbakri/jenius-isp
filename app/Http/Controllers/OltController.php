<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use App\Models\Telnet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class OltController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $olt = Olt::all();
        $title = 'Olt | Jenius';
        $activeLink = 'dashboard';
        $telnet = new Telnet();

        $getactiveolt = Olt::where('status', 1)->first();
        // dd($getactiveolt);
        if ($getactiveolt != null) {
            $result = $telnet->Connect($getactiveolt->host, $getactiveolt->user, $getactiveolt->password, $getactiveolt->port);
            if ($result == 0) {
                $status = true;
            } else {
                $status = false;
            }
        }

        return view('admin.olt', compact('title', 'activeLink', 'olt', 'status'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'host' => 'required',
            'user' => 'required',
            'port' => 'required|integer',
            'password' => 'required|min:8',
        ]);
        Olt::create($requestValidate);
        return redirect('/admin/olt')->with('success', 'Berhasil menambahkan olt baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(Olt $olt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Olt $olt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Olt $olt)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'host' => 'required',
            'user' => 'required',
            'port' => 'required|integer',
        ]);
        $requestValidate['password'] = $request->password != '' ? $request->password : $olt->password;
        Olt::find($olt->id)->update($requestValidate);
        return redirect('/admin/olt')->with('success', 'Berhasil mengubah data');
    }

    public function setActive($id)
    {
        Olt::where('status', 1)->update([
            'status' => 0
        ]);

        Olt::find($id)->update([
            'status' => 1
        ]);
        return redirect('/admin/olt')->with('success', 'Berhasil menghubungkan ke olt');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Olt $olt)
    {
        Olt::find($olt->id)->delete();
        return redirect('/admin/olt')->with('success', 'Berhasil menghapus olt [' . $olt->name . ']');
    }

    public function listonu()
    {
        $title = 'Daftar Onu | Jenius';
        $activeLink = 'dashboard';

        return view('admin.listOnu', compact('title', 'activeLink'));
    }
}
