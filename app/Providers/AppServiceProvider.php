<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Models\Umkm;
use App\Observers\TransactionObserver;
use App\Observers\UmkmObserver;
use Illuminate\Support\ServiceProvider;

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
        //
        Transaction::observe(TransactionObserver::class);
        Umkm::observe(UmkmObserver::class);
    }
}
