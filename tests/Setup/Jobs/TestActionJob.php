<?php

namespace Yormy\ConfirmablesLaravel\Tests\Setup\Jobs;

use Yormy\ConfirmablesLaravel\Jobs\BaseActionJob;
use Yormy\ConfirmablesLaravel\Tests\Setup\Events\ConfirmableExecuted;

class TestActionJob extends BaseActionJob
{

    public function handle(): void
    {
        event(new ConfirmableExecuted('',''));
    }
}
