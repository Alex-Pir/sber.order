<?php

namespace Sber\Payment\Exceptions;

use Exception;

class PaymentException extends Exception
{
    /**
     * @throws PaymentException
     */
    public static function throw(string $message)
    {
        throw new static($message);
    }
}