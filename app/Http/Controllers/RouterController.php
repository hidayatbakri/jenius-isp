<?php

namespace App\Http\Controllers;

use App\Models\Router;
use App\Models\RouterosAPI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RouterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public $setRouter = [];

    public function index()
    {
        $title = 'Router List  | Internet Smart';
        $activeLink = 'router';
        $routers = Router::all();
        return view('admin.router', compact('title', 'activeLink', 'routers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Add New Router | Internet Smart';
        $activeLink = 'router';
        return view('admin.createrouter', compact('title', 'activeLink'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required|min:3',
            'ip' => 'required',
            'username' => 'required',
        ]);

        $requestValidate['password'] = $request->password ? Hash::make($request->password) : '';

        Router::create($requestValidate);

        return redirect('/admin/router')->with('success', 'Successfully added a new router');
    }

    /**
     * Display the specified resource.
     */
    public function connectMikrotik($router)
    {
        // return 'ok';
        $ip = $router->ip;
        $user = $router->username;
        $pass = $router->password;
        $API = new RouterosAPI();
        $API->debug('false');
        $commandApi = '/ip/hotspot/user/print';

        if ($API->connect($ip, $user, $pass)) {
            // dd($API->comm($commandApi));
            return $API;
        } else {
            return 'gagal';
        }
    }



    public function show(Router $router)
    {
        // $resourcesRouter = $this->connectMikrotik($router);
        // $this->setRouter = $resourcesRouter;
        $resourcesRouter = 'oke';
        $title = 'Router List  | Internet Smart';
        $activeLink = 'routerMenu';
        $routerMenu = true;
        return view('admin.routerMenu.index', compact('title', 'activeLink', 'routerMenu', 'router', 'resourcesRouter'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Router $router)
    {
        $title = 'Router Update  | Internet Smart';
        $activeLink = 'routerMenu';
        return view('admin.editrouter', compact('title', 'activeLink', 'router'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Router $router)
    {
        $requestValidate = $request->validate([
            'name' => 'required|min:3',
            'ip' => 'required',
            'username' => 'required',
        ]);

        $requestValidate['password'] = $request->password ? Hash::make($request->password) : '';
        Router::where('id', $router->id)->update($requestValidate);
        return redirect('/admin/router')->with('success', 'Successfully updated a data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Router $router)
    {
        Router::find($router->id)->delete();
        return redirect('/admin/router')->with('success', 'Successfully deleted data');
    }

    // router menu
    public function address(Router $router)
    {
        $title = 'Router Address  | Internet Smart';
        $activeLink = 'routerIp';
        $routerMenu = true;
        return view('admin.routerMenu.address', compact('title', 'activeLink', 'routerMenu', 'router'));
    }
}
