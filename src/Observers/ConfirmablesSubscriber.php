<?php

namespace Yormy\ConfirmablesLaravel\Observers;

use Illuminate\Events\Dispatcher;
use Yormy\ConfirmablesLaravel\Observers\Interfaces\LoggableEventInterface;
use Yormy\ConfirmablesLaravel\Observers\Listeners\LogEvent;

class ConfirmablesSubscriber
{
    public function subscribe(Dispatcher $events): void
    {
        //        $events->listen(
        //            LoggableEventInterface::class,
        //            LogEvent::class
        //        );
    }
}
