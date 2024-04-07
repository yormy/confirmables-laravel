<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\ServiceProviders;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Yormy\ConfirmablesLaravel\Observers\ConfirmablesSubscriber;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        ConfirmablesSubscriber::class,
    ];
}
