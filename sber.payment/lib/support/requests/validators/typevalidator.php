<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Localization\Loc;
use Sber\Payment\Exceptions\ValidateRequestException;

Loc::loadMessages(__FILE__);

class TypeValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): mixed
    {
        if (!gettype($this->value) == $parameter) {
            ValidateRequestException::throw(Loc::getMessage('SBER_ORDER_TYPE_VALIDATOR_ERROR', [
                '#VALUE#' => $this->value,
                '#PARAMETER#' =>$parameter,
            ]));
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'type';
    }
}
