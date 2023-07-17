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


        $confirmable = new Confirmable();
        $confirmable->build($job, $data);
        $confirmable->emailRequired();
        $confirmable->phoneRequired();
        $confirmable->save();



        $confirmableExecute = Confirmable::first();
       // $confirmableExecute->setEmailVerified();
      //  $confirmableExecute->setPhoneVerified();
       // dd($confirmableExecute->isEmailVerified());
        $isVerified = $confirmableExecute->isAllVerified();

        $execute = $confirmableExecute->execute();

        dd($execute);
    }
}
