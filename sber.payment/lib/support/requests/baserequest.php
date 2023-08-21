<?php

namespace Sber\Payment\Support\Requests;

use Bitrix\Main\Request;
use Sber\Payment\Contracts\ValidatorContract;
use Sber\Payment\Support\Requests\Validators\GreaterThenOrEqualsValidator;
use Sber\Payment\Support\Requests\Validators\RegValidator;
use Sber\Payment\Support\Requests\Validators\RequiredValidator;
use Sber\Payment\Support\Requests\Validators\TypeValidator;

abstract class BaseRequest
{
    public function __construct(protected readonly Request $request)
    {
    }

    public function validated(): array
    {
        $validators = $this->validators();

        foreach ($this->rules() as $parameterCode => $rule) {
            foreach ($rule as $ruleKey => $validatorKey) {
                if (!isset($validators[$ruleKey])) {
                    continue;
                }

                $resultFields[$parameterCode] = (new $validators[$ruleKey]($this->request, $parameterCode))
                    ->validate($validatorKey);
            }


        }

        return $resultFields ?? [];
    }

    /**
     * @return ValidatorContract[]
     */
    protected function validators(): array
    {
        return [
            RegValidator::key() => RegValidator::class,
            RequiredValidator::key() => RequiredValidator::class,
            TypeValidator::key() => TypeValidator::class,
            GreaterThenOrEqualsValidator::key() => GreaterThenOrEqualsValidator::class,
        ];
    }

    abstract protected function rules(): array;
}
