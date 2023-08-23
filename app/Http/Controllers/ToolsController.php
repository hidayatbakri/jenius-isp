<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        $tools = Tool::all();
        return view('admin.tools.index', compact('title', 'activeLink', 'tools'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'head' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'foto' => 'required|max:516|mimes:jpg,jpeg,png',
        ]);
        $requestValidate['foto'] = $request->file('foto')->store('alat');

        Tool::create($requestValidate);

        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tool $tool)
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        return view('admin.tools.show', compact('title', 'activeLink', 'tool'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tool $tool)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tool $tool)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'head' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($request->foto != null) {
            Storage::disk()->delete($tool->foto);
            $requestValidate['foto'] = $request->file('foto')->store('alat');
        }

        Tool::where('id', $tool->id)->update($requestValidate);

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tool $tool)
    {
        Tool::where('id', $tool->id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    public function map()
    {
        $title = 'Lokasi Alat | Jenius';
        $activeLink = 'dashboard';
        $tools = Tool::all();
        $tools = json_encode($tools);
        return view('admin.tools.map', compact('title', 'activeLink', 'tools'));
    }
}
