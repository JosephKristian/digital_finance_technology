<?php

namespace App\Providers;

use App\Models\Transaction;
use App\Models\Umkm;
use App\Observers\TransactionObserver;
use App\Observers\UmkmObserver;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Verifikasi Alamat Email DIGIFINTECH')
                ->line('Tekan tombol verifikasi untuk memproses alamat email anda.')
                ->action('Verifikasi Alamat Email', $url);
        });
    }
}
