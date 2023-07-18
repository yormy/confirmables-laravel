<?php

namespace Yormy\ConfirmablesLaravel\Tests\Setup\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'test_users';

    protected $fillable = [
        'email',
    ];

    public $timestamps = false;
}
