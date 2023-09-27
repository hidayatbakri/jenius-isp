<?php

namespace App\Http\Controllers;

use App\Models\MandiriApi;
use App\Models\Paket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function transaction()
    {
        $title = 'Pengaturan Transaksi | Jenius';
        $activeLink = 'settings';
        $paket = Paket::get();
        $transactionSettings = DB::table('transactionsettings')->first();
        // dd($transactionSettings);
        return view('admin.settings.transaction', compact('title', 'activeLink', 'transactionSettings', 'paket'));
    }

    public function bank()
    {
        $mandiri = new MandiriApi();
        dd($mandiri->auth());
    }

    public function transactionCreate(Request $request)
    {
        $requestValidate = $request->validate([
            'biaya_admin' => 'required|integer',
            'status_production' => 'required|integer'
        ]);
        $cek = DB::table('transactionsettings')->get();
        if ($cek != null) {
            DB::table('transactionsettings')->insert($requestValidate);
            return redirect('/admin/settings/transaction')->with('success', 'Berhasil manambah data');
        }
        return redirect('/admin/settings/transaction')->with('error', 'Gagal manambah data');
    }

    public function paketCreate(Request $request)
    {
        $requestValidate = $request->validate([
            'speed' => 'required|integer',
            'price' => 'required|integer'
        ]);

        Paket::create($requestValidate);
        return redirect('/admin/settings/transaction')->with('success', 'Berhasil manambah data');
    }

    public function paketUpdate(Request $request, $id)
    {
        $requestValidate = $request->validate([
            'speed' => 'required|integer',
            'price' => 'required|integer'
        ]);

        Paket::where('id', $id)->update($requestValidate);
        return redirect('/admin/settings/transaction')->with('success', 'Berhasil mengubah data');
    }

    public function transactionUpdate(Request $request, $id)
    {
        $requestValidate = $request->validate([
            'biaya_admin' => 'required|integer',
            'status_production' => 'required|integer',
        ]);

        if ($request->status < 0 || $request->status > 1) {
            return view('admin.settings.transaction');
            die;
        }

        DB::table('transactionsettings')
            ->where('id', $id)
            ->update($requestValidate);

        return redirect('/admin/settings/transaction')->with('success', 'Berhasil mengubah data');
    }

    public function api(Request $request)
    {
        $title = 'Pengaturan Api | Jenius';
        $activeLink = 'settings';
        $apiTokens = $request->user()->tokens;
        return view('admin.settings.apiToken', compact('title', 'activeLink', 'apiTokens'));
    }

    public function createApi(Request $request)
    {
        $request->user()->createToken($request->token_name)->plainTextToken;
        return redirect('/admin/settings/api');
    }

    public function deleteApi(Request $request, $id)
    {
        $request->user()->tokens()->where('id', $id)->delete();
        return redirect('/admin/settings/api');
    }
}
