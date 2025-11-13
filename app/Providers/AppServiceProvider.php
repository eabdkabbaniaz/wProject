<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema; // ← هذا السطر مهم جدًا

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Schema::defaultStringLength(191); // ← يحل مشكلة طول الـ index في PostgreSQL
    }

    public function register()
    {
        //
    }
}
