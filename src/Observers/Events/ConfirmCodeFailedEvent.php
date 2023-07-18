<?php

namespace Yormy\ConfirmablesLaravel\Observers\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmCodeFailedEvent
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        protected readonly ?string $ip = null,
        protected $user = null,
    ) {
    }
}
