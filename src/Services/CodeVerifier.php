<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Services;

use Yormy\ConfirmablesLaravel\Models\Confirmable;
use Yormy\ConfirmablesLaravel\Models\ConfirmableCode;
use Yormy\ConfirmablesLaravel\Observers\Events\ConfirmCodeFailedEvent;

class CodeVerifier
{
    public static function verifyForEmail(string $code, string $ip = null, $user = null): ?ConfirmableCode
    {
        $codeVerified = self::verify($code, $ip, $user);

        if (!$codeVerified || $codeVerified->method !== Confirmable::METHOD_EMAIL) {
            return null;
        }

        return $codeVerified;
    }

    public static function verifyForPhone(string $code, string $ip = null, $user = null): ?ConfirmableCode
    {
        $codeVerified = self::verify($code, $ip, $user);

        if (!$codeVerified || $codeVerified->method !== Confirmable::METHOD_PHONE) {
            return null;
        }

        return $codeVerified;
    }

    private static function verify(string $code, string $ip = null, $user = null): ?ConfirmableCode
    {
        $confirmableCode = ConfirmableCode::where('code', $code)
            ->notExpired();

        // todo: fout, geen ip passed, dan loopt dit toch door => tests voor maken
        $confirmableCode->allowIp($ip);

        $confirmableCode->allowUser($user);

        $foundCode =  $confirmableCode->first();

        if (!$foundCode) {
            event(new ConfirmCodeFailedEvent($ip, $user));
        }

        return $foundCode;
    }
}
