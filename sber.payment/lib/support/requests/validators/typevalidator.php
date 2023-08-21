<?php

namespace Sber\Payment\Support\Requests\Validators;

use Sber\Payment\Exceptions\ValidateRequestException;

class TypeValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): mixed
    {
        if (!gettype($this->value) == $parameter) {
            ValidateRequestException::throw("Тип данных для $this->value не $parameter");
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'type';
    }
}
