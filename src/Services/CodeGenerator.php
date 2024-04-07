<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Services;

class CodeGenerator
{
    const TYPE_NUMERIC = 1;

    const TYPE_NUMERIC_ALPHA_UPPERCASE = 2;

    const TYPE_NUMERIC_ALPHA_LOWERCASE = 3;

    const TYPE_NUMERIC_ALPHA_UPPERLOWERCASE = 4;

    public static function generate(int $type = CodeGenerator::TYPE_NUMERIC_ALPHA_UPPERCASE, int $length = 6): string
    {
        $characters = match ($type) {
            static::TYPE_NUMERIC => '0123456789',
            static::TYPE_NUMERIC_ALPHA_UPPERCASE => '23456789ABCDEFGHIJKLMNOPQRSTUVWXYZ',
            static::TYPE_NUMERIC_ALPHA_LOWERCASE => '23456789abcdefghijklmnopqrstuvwxyz',
            static::TYPE_NUMERIC_ALPHA_UPPERLOWERCASE => '23456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            default => '23456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
        };

        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
