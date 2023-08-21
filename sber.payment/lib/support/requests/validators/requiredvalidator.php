<?php

namespace Sber\Payment\Support\Requests\Validators;

use Sber\Payment\Exceptions\ValidateRequestException;

class RequiredValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): mixed
    {
        if ($parameter === true && (is_null($this->value) || strlen(trim($this->value)) == 0)) {
            ValidateRequestException::throw("Значение $this->requestParameterCode не может быть пустым");
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'required';
    }
}
