<?php

namespace App\Http\Controllers;

use App\Models\Odp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OdpController extends Controller
{
    public function show(Odp $odp)
    {
        $title = 'Alat | Jenius';
        $activeLink = 'dashboard';
        $tool = Odp::with('odc')->where('id', $odp->id)->first();
        return view('admin.tools.show', compact('title', 'activeLink', 'tool'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Odp $odp)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'odc_id' => 'required',
            'head' => 'required',
            'address' => 'required',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($request->foto != null) {
            Storage::disk()->delete($odp->foto);
            $requestValidate['foto'] = $request->file('foto')->store('alat');
        }

        Odp::where('id', $odp->id)->update($requestValidate);

        return redirect()->back()->with('success', 'Berhasil mengubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Odp $odp)
    {
        //
    }
}
