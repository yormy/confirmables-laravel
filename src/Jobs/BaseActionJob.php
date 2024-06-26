<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Yormy\ConfirmablesLaravel\Tests\Helpers\DebugNotification;

class BaseActionJob implements ShouldBeEncrypted, ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        private string $firstname = ''
    ) {
    }

    public function handle(): void
    {
        DebugNotification::send('job processed: '.$this->firstname);
        // do something with data
    }
}
