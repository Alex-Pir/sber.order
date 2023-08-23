<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Sber\Payment\Exceptions\ValidateRequestException;

Loc::loadMessages(__FILE__);

class TableExistValidator extends BaseValidator
{
    /**
     * @throws ValidateRequestException
     */
    public function validate(mixed $parameter): array
    {
        if (!class_exists($parameter) || !((new $parameter()) instanceof DataManager)) {
            ValidateRequestException::throw(Loc::getMessage('SBER_ORDER_TABLE_EXIST_VALIDATOR_ERROR', [
                '#PARAMETER#' => $parameter
            ]));
        }

        return $parameter::getById($this->value)->fetch();
    }

    public static function key(): string
    {
        return 'exist';
    }
}