<?php

namespace App\Providers;

use App\Models\Olt;
use App\Models\Telnet;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Sanctum::usePersonalAccessTokenModel(PersonalAccessToken::class);
        // Cek apakah ada koneksi yang sudah tersimpan di cache

    }

    protected $listen = [
        ApiResponseReceived::class => [
            ProcessApiResponse::class,
        ],
    ];
}
