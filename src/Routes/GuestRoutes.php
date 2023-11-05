<?php

namespace Yormy\ConfirmablesLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ConfirmablesLaravel\Controllers\CodeVerifyController;
use Yormy\ConfirmablesLaravel\Domain\Subscription\Http\Controllers\UnsubscribeController;

class GuestRoutes
{
    public static function register(): void
    {
        Route::macro('ConfirmablesRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('confirmables.')
                ->group(function () {

                    Route::prefix('action/email')
                        ->name('action.email.')
                        ->group(function () {
                            Route::post('/verify', [CodeVerifyController::class, 'verifyByEmail'])->name('verify');
                        });
                });
        });
    }
}
