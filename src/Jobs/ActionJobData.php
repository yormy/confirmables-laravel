<?php

namespace Yormy\ConfirmablesLaravel\Jobs;

class ActionJobData extends BaseActionData
{
    public string $firstname;

    public function toArray()
    {
        return [
            'firstname' => $this->firstname
        ];
    }
}
