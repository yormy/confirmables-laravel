<?php

namespace Yormy\ConfirmablesLaravel\tests\Traits;

use Yormy\ConfirmablesLaravel\tests\Models\User;

trait UserTrait
{
    private function createUser()
    {
        $user = User::create([
            'email' => 'test@exampel.com',
        ]);

        return $user;
    }
}
