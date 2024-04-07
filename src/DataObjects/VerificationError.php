<?php

declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\DataObjects;

class VerificationError
{
    public const INVALID_CODE = [
        'httpCode' => 422,
        'type' => 'code',
        'code' => 'INVALID_CODE',
        'messageKey' => 'confirmables::validation.code_invalid',
    ];
}
