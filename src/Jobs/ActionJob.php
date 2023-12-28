<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Jobs;

use Yormy\ConfirmablesLaravel\Tests\Helpers\DebugNotification;

class ActionJob extends BaseActionJob
{

    public function __construct(
        private string $firstname = ''
    ) {
    }

    public function handle(): void
    {
        DebugNotification::send('job processed: '. $this->firstname);
        // do something with data
    }


}
