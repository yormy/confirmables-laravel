<?php

namespace Yormy\ConfirmablesLaravel\Tests\Traits;

use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Models\ConfirmableCode;

trait CodeTrait
{
    private function createCode(): ConfirmableCode
    {
        $action = $this->createAction();

        $code = new ConfirmableCode();
        $result = $code->generate();
        $result->setExpiresAt();
        $result->confirmable_id = $action->id;
        $result->save();

        return $result;
    }

    private function createAction(): Confirmable
    {
        $confirmable = new Confirmable();
        $confirmable->payload = 'dddd';
        $confirmable->save();

        return $confirmable;
    }
}
