<?php

namespace Yormy\ConfirmablesLaravel\Tests\Traits;

use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Tests\Setup\Jobs\TestActionJob;
use Yormy\ConfirmablesLaravel\Tests\Setup\Jobs\TestActionJobData;

trait ConfirmableTrait
{
    private function createConfirmable(): Confirmable
    {
        $job = new TestActionJob();
        $data = new TestActionJobData();
        $data->firstname = 'Andrew';

        $confirmable = new Confirmable();
        $confirmable->build($job, $data);
        $confirmable->save();

        return $confirmable;
    }
}
