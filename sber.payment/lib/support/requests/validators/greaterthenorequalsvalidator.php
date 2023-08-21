<?php

namespace Sber\Payment\Support\Requests\Validators;

use Sber\Payment\Exceptions\ValidateRequestException;

class GreaterThenOrEqualsValidator extends BaseValidator
{
    public function validate(mixed $parameter): mixed
    {
        if (!is_numeric($this->value) || $this->value < $parameter) {
            ValidateRequestException::throw("Значение $this->requestParameterCode должно быть больше или равно $parameter");
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'min';
    }
}