<?php

namespace Yormy\ConfirmablesLaravel\Tests\Setup\Jobs;

use Yormy\ConfirmablesLaravel\Jobs\BaseActionData;

class TestActionJobData extends BaseActionData
{
    public string $firstname;

    public function toArray()
    {
        return [
            'firstname' => $this->firstname,
        ];
    }
}
