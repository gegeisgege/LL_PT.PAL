<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\Event;
use App\Models\AuditLog;

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
        Event::listen(Login::class, function (Login $event) {
            AuditLog::record('LOGIN', $event->user);
        });

        Event::listen(Logout::class, function (Logout $event) {
            AuditLog::record('LOGOUT', $event->user);
        });

        Event::listen(Failed::class, function (Failed $event) {
            AuditLog::create([
                'user_id' => null,
                'action' => 'FAILED_LOGIN',
                'result' => 'FAILURE',
                'created_at' => now(),
            ]);
        });
    }
}