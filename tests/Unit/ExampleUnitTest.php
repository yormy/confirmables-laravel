<?php

namespace Yormy\ConfirmablesLaravel\tests\Unit;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Yormy\ConfirmablesLaravel\Jobs\ActionJob;
use Yormy\ConfirmablesLaravel\Jobs\ActionJobData;
use Yormy\ConfirmablesLaravel\Tests\Helpers\DebugNotification;
use Yormy\ConfirmablesLaravel\Models\Confirmable;
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

        Confirmable::truncate();

        // prepare action (request email change)
        $job = new ActionJob();
        $data = new ActionJobData();
        $data->firstname = 'ssssss';

        // make confirmable
        $confirmable = Confirmable::create([
            'payload' => serialize($job),
            'arguments' => serialize($data),
            'requires_email' => true,
        ]);


        //$confirmable->setEmailVerified();

        $isVerified = $confirmable->isVerified();


        $execute = $confirmable->execute();

        dd($execute);
    }
}
