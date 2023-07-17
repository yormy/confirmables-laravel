<?php

namespace Yormy\ConfirmablesLaravel\tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use jdavidbakr\MailTracker\MailTrackerServiceProvider;
use LiranCo\NotificationSubscriptions\NotificationSubscriptionsServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Spatie\LaravelRay\RayServiceProvider;
use Yormy\ConfirmablesLaravel\ConfirmablesServiceProvider;

abstract class TestCase extends BaseTestCase
{
    // disable after migration to inpect db during test
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->updateEnv();

        parent::setUp();

        $this->setUpConfig();
    }

    protected function getPackageProviders($app)
    {
        return [
            ConfirmablesServiceProvider::class,
            RayServiceProvider::class,
        ];
    }

    protected function setUpConfig(): void
    {
        config(['app.key' => 'base64:yNmpwO5YE6xwBz0enheYLBDslnbslodDqK1u+oE5CEE=']);

      //  Route::ChaskiUnsubscribeRoutes();
    }

    /**
     * We need to update the .env.example
     * because in a job the previous settings in config are not used and the settings from .env are used.
     */
    protected function updateEnv()
    {
        copy('./tests/Setup/.env', './vendor/orchestra/testbench-core/laravel/.env');
    }

    /**
     * @psalm-return \Closure():'next'
     */
    public function getNextClosure(): \Closure
    {
        return function () {
            return 'next';
        };
    }
}
