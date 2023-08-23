<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Localization\Loc;
use Sber\Payment\Exceptions\ValidateRequestException;

Loc::loadMessages(__FILE__);

class RequiredValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): mixed
    {
        if ($parameter === true && (is_null($this->value) || strlen(trim($this->value)) == 0)) {
            ValidateRequestException::throw(Loc::getMessage('SBER_ORDER_REQUIRED_VALIDATOR_ERROR', [
                '#CODE#' => $this->requestParameterCode,
            ]));
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'required';
    }
}
