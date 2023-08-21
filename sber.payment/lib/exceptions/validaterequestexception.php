<?php

namespace Sber\Payment\Exceptions;

use Exception;

class ValidateRequestException extends Exception
{
    /**
     * @throws ValidateRequestException
     */
    public static function throw(string $message)
    {
        throw new static($message, 400);
    }
}
