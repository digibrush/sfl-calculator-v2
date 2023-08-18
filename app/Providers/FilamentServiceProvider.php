<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Filament\Navigation\UserMenuItem;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                UserMenuItem::make()
                    ->label('User Profile')
                    ->url('/admin/users/'.Auth::id().'/edit')
                    ->icon('heroicon-s-user'),
            ]);

            Filament::registerRenderHook(
                'body.end',
                fn (): View => view('layout.inspectlet'),
            );

            Filament::registerRenderHook(
                'body.end',
                fn (): View => view('layout.botman'),
            );
        });
    }
}
