<?php

use Yormy\ConfirmablesLaravel\tests\Models\User;

return [

    'default_language' => 'en',
    'languages' => [
        'en',
        'nl',
    ],

    'models' => [
//        // List here all the models that are notifyables.
//        // if you send notifications to users and admins, list them both
//        'notifiables' => [
//            User::class,
//            //Admin::class,
//        ],
//
//        // set your overrideesfor encryption
//        'sent_email' => SentEmail::class,
//        'sent_email_log' => SentEmailLog::class,
    ],

    'prevented_content_logging' => '*** CONTENT NOT STORED FOR SECURITY ***',

    'default_layout' => [
        'html' => 'confirmables-laravel::layouts.html.red',
        'text' => 'confirmables-laravel::layouts.text.main',
    ],

    'unsubscribe_view' => [
        'invalid_token' => 'confirmables-laravel::unsubscribe.invalid',
        'success' => 'confirmables-laravel::unsubscribe.success',
        'prevented' => 'confirmables-laravel::unsubscribe.prevented',
    ],
];
