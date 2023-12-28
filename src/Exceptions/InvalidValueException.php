<?php declare(strict_types=1);

namespace Yormy\ConfirmablesLaravel\Exceptions;

use Exception;

class InvalidValueException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
