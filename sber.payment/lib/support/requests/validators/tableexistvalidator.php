<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\ORM\Data\DataManager;
use Sber\Payment\Exceptions\ValidateRequestException;

class TableExistValidator extends BaseValidator
{
    public function validate(mixed $parameter): array
    {
        if (!class_exists($parameter) || !((new $parameter()) instanceof DataManager)) {
            ValidateRequestException::throw("Некорректный класс $parameter");
        }

        return $parameter::getById($this->value)->fetch();
    }

    public static function key(): string
    {
        return 'exist';
    }
}