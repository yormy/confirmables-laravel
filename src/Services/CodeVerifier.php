<?php

namespace Yormy\ConfirmablesLaravel\Services;

use Yormy\ConfirmablesLaravel\Models\ConfirmableCode;
use Yormy\ConfirmablesLaravel\Observers\Events\ConfirmCodeFailedEvent;

class CodeVerifier
{
    public static function verify(string $code, string $ip = null, $user = null): ?ConfirmableCode
    {
        $confirmableCode = ConfirmableCode::where('code', $code)
            ->notExpired();

        // fout, geen ip passed, dan loopt dit toch door => tests voor maken
        $confirmableCode->allowIp($ip);

        $confirmableCode->allowUser($user);

        $foundCode =  $confirmableCode->first();

        if (!$foundCode) {
            event(new ConfirmCodeFailedEvent($ip, $user));
        }

        return $foundCode;
    }
}
