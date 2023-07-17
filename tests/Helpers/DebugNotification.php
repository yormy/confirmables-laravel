<?php

namespace Yormy\ConfirmablesLaravel\Tests\Helpers;

use Illuminate\Support\Facades\Mail;

class DebugNotification
{
    public static function send(string $subject)
    {
        config(['mail.default' => 'smtp']);
        config(['mail.mailers.smtp.host' => 'maildev']);
        config(['mail.mailers.smtp.port' => 25]);
        config(['mail.mailers.smtp.encryption' => null]);
        config(['mail.mailers.smtp.verify_peer' => false]);

        Mail::raw('Hello, welcome to Laravel!', function ($message) use ($subject) {
            $message
                ->to('test@test.com')
                ->subject($subject);
        });
    }
}
