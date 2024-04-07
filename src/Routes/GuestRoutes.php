<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ConfirmablesLaravel\Controllers\CodeVerifyController;

class GuestRoutes
{
    public static function register(): void
    {
        Route::macro('ConfirmablesRoutes', function (string $prefix = ''): void {
            Route::prefix($prefix)
                ->name('confirmables.')
                ->group(function (): void {
                    Route::prefix('action/email')
                        ->name('action.email.')
                        ->group(function (): void {
                            Route::post('/verify', [CodeVerifyController::class, 'verifyByEmail'])->name('verify');
                        });
                });
        });
    }
}
