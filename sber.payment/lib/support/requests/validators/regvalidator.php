<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Localization\Loc;
use Sber\Payment\Exceptions\ValidateRequestException;

Loc::loadMessages(__FILE__);

class RegValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): bool
    {
        if (!preg_match($parameter, $this->value)) {
            ValidateRequestException::throw(Loc::getMessage('SBER_ORDER_REG_VALIDATOR_ERROR', [
                '#VALUE#' => $this->value,
            ]));
        }

        return $this->value;
    }

    public static function key(): string
    {
        return 'reg';
    }
}
