<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use App\Models\Telnet;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {

        $title = 'Dashboard Admin | Jenius';
        $activeLink = 'dashboard';
        return view('admin.index', compact('title', 'activeLink'));
    }
}
