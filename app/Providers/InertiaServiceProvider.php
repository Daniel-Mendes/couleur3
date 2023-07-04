<?php

namespace App\Providers;

use App\Enums\NotificationType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class InertiaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        RedirectResponse::macro(
            'flash',
            function (NotificationType $type, string $body) {
                session()->flash('notification', [
                    'type' => $type,
                    'body' => $body,
                ]);
                /** @var RedirectResponse $this */
                return $this;
            }
        );

        RedirectResponse::macro('success', function (string $body) {
            return $this->flash(NotificationType::SUCCESS, $body);
        });

        RedirectResponse::macro('error', function (string $body) {
            return $this->flash(NotificationType::ERROR, $body);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
