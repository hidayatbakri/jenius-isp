<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OltController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ToolsController;
use App\Http\Livewire\DataMikrotik;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [AuthController::class, 'index'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/register', [AuthController::class, 'store'])->middleware('guest');
Route::get('/verify/{email}', [AuthController::class, 'verify'])->middleware('guest');
Route::post('/verify', [AuthController::class, 'checkOtp'])->middleware('guest');
Route::post('/verify/resend/{email}', [AuthController::class, 'resendOtp'])->middleware('guest');

Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['checkLevel:admin'])->group(function () {
  Route::get('/admin', [CustomerController::class, 'index']);
  Route::get('/home', [AdminController::class, 'index']);
  Route::resource('/admin/router', RouterController::class);
  Route::get('/admin/customers/map', [CustomerController::class, 'map']);
  Route::resource('/admin/customers', CustomerController::class);
  Route::resource('/admin/olt', OltController::class);
  Route::get('/admin/tools/map', [ToolsController::class, 'map']);
  Route::resource('/admin/tools', ToolsController::class);
  Route::put('/admin/olt/setActive/{id}', [OltController::class, 'setActive']);

  // Route onu
  Route::get('/admin/listonu', [OltController::class, 'listonu']);

  // Router menu
  Route::get('/admin/routerMenu/ipaddress/{router}', [RouterController::class, 'address']);

  // Route settings
  Route::get('/admin/settings/transaction', [SettingsController::class, 'transaction']);
  Route::post('/admin/settings/transaction', [SettingsController::class, 'transactionCreate']);
  Route::post('/admin/settings/transaction/{id}', [SettingsController::class, 'transactionUpdate']);
  Route::post('/admin/settings/paket', [SettingsController::class, 'paketCreate']);
  Route::post('/admin/settings/paket/{id}', [SettingsController::class, 'paketUpdate']);
  Route::get('/admin/settings/api', [SettingsController::class, 'api']);
  Route::post('/admin/settings/api', [SettingsController::class, 'createApi']);
  Route::delete('/admin/settings/api/{id}', [SettingsController::class, 'deleteApi']);

  // Route alat

});

// Route payment
Route::get('/payment', [PaymentController::class, 'index']);
Route::get('/payment/finish', [PaymentController::class, 'finish']);
Route::post('/payment/finish', [PaymentController::class, 'finishPost']);
Route::post('/payment/postData', [PaymentController::class, 'postData']);

Route::post('/livewire/message/transaction-data', [CustomerController::class, 'log']);
