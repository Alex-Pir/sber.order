<?php

namespace Sber\Payment\Support\Requests\Validators;

use Bitrix\Main\Request;
use Sber\Payment\Contracts\ValidatorContract;
use Sber\Payment\Support\Traits\HasParameters;

abstract class BaseValidator implements ValidatorContract
{
    use HasParameters;

    protected mixed $value;

    public function __construct(
        protected readonly Request $request,
        protected readonly string $requestParameterCode
    ) {
        $this->value = $this->getParameter($requestParameterCode);
    }
}
