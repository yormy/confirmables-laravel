<?php

namespace Yormy\ConfirmablesLaravel\Tests\Setup\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ConfirmableExecuted
{
    use Dispatchable;
    use SerializesModels;

    public function __construct()
    {
    }
}
