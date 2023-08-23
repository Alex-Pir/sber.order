<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Localization\Loc;
use Sber\Payment\Exceptions\ValidateRequestException;

Loc::loadMessages(__FILE__);

class GreaterThenOrEqualsValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): mixed
    {
        if (!is_numeric($this->value) || $this->value < $parameter) {
            ValidateRequestException::throw(Loc::getMessage('SBER_ORDER_GREATER_THEN_OR_EQUALS_VALIDATOR_ERROR', [
                '#CODE#' => $this->requestParameterCode,
                '#PARAMETER#' => $parameter,
            ]));
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'min';
    }
}