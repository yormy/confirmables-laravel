<?php

namespace Yormy\ConfirmablesLaravel\Domain\Shared\Services;

use Illuminate\Support\Facades\Crypt;

class Encryption
{
    public static function encrypt(?string $mailable): ?string
    {
        return Crypt::encryptString($mailable);
    }

    public static function decrypt(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
