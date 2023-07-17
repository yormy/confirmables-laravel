<?php

namespace Yormy\ConfirmablesLaravel\Routes;

use Illuminate\Support\Facades\Route;
use Yormy\ConfirmablesLaravel\Domain\Subscription\Http\Controllers\UnsubscribeController;

class GuestRoutes
{
    public static function register(): void
    {
        Route::macro('ChaskiUnsubscribeRoutes', function (string $prefix = '') {
            Route::prefix($prefix)
                ->name('confirmables.')
                ->group(function () {

                    Route::prefix('email')
                        ->name('email.')
                        ->group(function () {
                            Route::get('/u/{token}', [UnsubscribeController::class, 'unsubscribe'])->name('unsubscribe');
                        });
                });
        });
    }
}
