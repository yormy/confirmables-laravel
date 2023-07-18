<?php

namespace Yormy\ConfirmablesLaravel\Tests\Setup\Jobs;

use Yormy\ConfirmablesLaravel\Jobs\BaseActionJob;

class TestActionJob extends BaseActionJob
{

    public function __construct(
        private string $firstname = ''
    ) {
    }

    public function handle(): void
    {
        // do something with data
    }


}
