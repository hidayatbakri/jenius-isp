<?php

namespace App\Http\Controllers;

use DateTimeZone;
use Config;
use App\Mail\SendEmail;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config as FacadesConfig;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $requestValidate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $checkActivate = User::where('email', $requestValidate['email'])->first();
        if (Auth::attempt($requestValidate)) {
            if ($checkActivate['email_verified_at']) {
                $path = Auth::user()->level == 'admin' ? 'admin' : 'user';
                return redirect('/' . $path);
            }
            return redirect()->back()->with('error', 'Account has not been activated');
        }
        return redirect()->back()->with('error', 'Username or password is wrong');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Successfully signed out');
    }

    public function otpCode()
    {
        // dd(Carbon::now()->addMinute());
        $otp = rand(1000, 9999);
        Cache::put('otp', $otp, 60);
        Cache::put('fromtime', Carbon::now()->addMinute(), 60);
        return $otp;
    }

    public function resendOtp($email)
    {
        $getemail = Cache::get('email');

        if ((md5($getemail) != $email) || (!Cache::get('email') || (!Cache::get('name')))) {
            return redirect('/');
        }

        $data_email = [
            'subject' => 'no-reply | Aktifkan akun anda',
            'type' => 'otpRegister',
            'otp' => $this->otpCode(),
            'username' => Cache::get('name'),
            'link' => env('APP_URL') . '/verify/' . $email,
        ];

        Mail::to(Cache::get('email'))->send(new SendEmail($data_email));
        return redirect()->back();
    }


    public function verify($email)
    {
        $data = $email;
        $getemail = Cache::get('email');
        if ((md5($getemail) != $email) || (!Cache::get('email') || (!Cache::get('name')))) {
            return redirect('/');
            Cache::flush();
        }
        return view('auth.verify', compact('data'));
    }

    public function checkOtp(Request $request)
    {
        $requestValidate = $request->validate([
            'otp' => 'required|integer'
        ]);
        $getemail = Cache::get('email');

        if (Cache::get('otp') == $requestValidate['otp']) {

            User::where('email', $getemail)->update(['email_verified_at' => now()]);
            Cache::forget('otp');
            Cache::flush();

            return redirect('/')->with('success', 'Successfully activated the account');
        }
        return redirect()->back()->with('error', 'Incorrect otp code');
    }

    public function register()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $requestValidate = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8'
        ]);

        $idmail = md5($requestValidate['email']);
        $data_email = [
            'subject' => 'no-reply | Activate your account',
            'type' => 'otpRegister',
            'otp' => $this->otpCode(),
            'username' => $requestValidate['name'],
            'link' => env('APP_URL') . '/verify/' . $idmail,
        ];


        Cache::put('email', $requestValidate['email']);
        Cache::put('name', $requestValidate['name']);

        $requestValidate['password'] = Hash::make($request->password);
        $requestValidate['level'] = 'admin';

        User::create($requestValidate);

        Mail::to($requestValidate['email'])->send(new SendEmail($data_email));
        return redirect('/verify/' . $idmail)->with('success', 'Successfully created a new account');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
