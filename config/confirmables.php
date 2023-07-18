<?php

use Yormy\ConfirmablesLaravel\Tests\Setup\Models\User;

return [

    'default_language' => 'en',
    'languages' => [
        'en',
        'nl',
    ],

    'confirm_code' => [
        'lifetime_in_minutes' => 70
    ]
];
