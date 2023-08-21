<?php

namespace Sber\Payment\Support\Requests\Validators;

use Sber\Payment\Exceptions\ValidateRequestException;

class RegValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): bool
    {
        if (!preg_match($parameter, $this->value)) {
            ValidateRequestException::throw("Значение $this->value некорректно");
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'reg';
    }
}
