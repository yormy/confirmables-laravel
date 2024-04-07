<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Observers;

use Illuminate\Events\Dispatcher;

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
