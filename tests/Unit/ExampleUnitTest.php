<?php

namespace Yormy\ConfirmablesLaravel\tests\Unit;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yormy\ConfirmablesLaravel\Jobs\ActionJob;
use Yormy\ConfirmablesLaravel\Jobs\ActionJobData;
use Yormy\ConfirmablesLaravel\Tests\Helpers\DebugNotification;
use Yormy\ConfirmablesLaravel\Models\Action;
use Yormy\ConfirmablesLaravel\Tests\TestCase;

class ExampleUnitTest extends TestCase
{
    /**
     * @test
     * @group xxx
     */
    public function example(): void
    {
        //TestActionJob::dispatch(); // ip dispatch store....

        Action::truncate();

        // prepare action (request email change)
        $job = new ActionJob();
        $data = new ActionJobData();
        $data->firstname = 'ssssss';

        $payload = serialize($job);
        $arguments = serialize($data);
        Action::create([
            'payload' => $payload,
            'arguments' => $arguments
        ]);


        // ??
        // if action is verified => dispatch

        // complete action (request email change)
        $todo = Action::first();
        $unserialized = unserialize($todo->payload);
        $arguments = unserialize($todo->arguments);

        $unserialized->dispatch(...$arguments->toArray());


        dd($payload);
    }
}
