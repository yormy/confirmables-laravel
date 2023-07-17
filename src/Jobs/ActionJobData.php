<?php

namespace Yormy\ConfirmablesLaravel\Jobs;

class ActionJobData
{
    public string $firstname;

    public function toArray()
    {
        return [
            'firstname' => $this->firstname
        ];
    }
}
