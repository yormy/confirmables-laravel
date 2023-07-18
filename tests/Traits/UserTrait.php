<?php

namespace Yormy\ConfirmablesLaravel\Tests\Traits;

use Yormy\ConfirmablesLaravel\Tests\Setup\Models\User;

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
