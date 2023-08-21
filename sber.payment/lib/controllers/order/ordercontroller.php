<?php

namespace Sber\Payment\Controllers\Order;

use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Exception;
use Sber\Payment\Controllers\Order\Actions\CreateOrderAction;
use Sber\Payment\Controllers\Order\Actions\OrderPayAction;
use Sber\Payment\Controllers\Order\Requests\OrderCreateRequest;
use Sber\Payment\Controllers\Order\Requests\OrderPayRequest;

class OrderController extends Controller
{
    public function configureActions(): array
    {
        $filters = [
            'prefilters' => [
                new HttpMethod(
                    [HttpMethod::METHOD_POST],
                ),
                new Csrf()
            ]
        ];

        return [
            'create' => $filters,
            'pay' => $filters,
        ];
    }

    public function createAction(): array|null
    {
        try {
            return (new CreateOrderAction())->execute(
                (new OrderCreateRequest($this->request))->getDto()
            );
        } catch (Exception $ex) {
            $this->addError(new Error($ex->getMessage(), $ex->getCode()));
        }

        return null;
    }

    public function payAction(): string|null
    {
        try {
            return (new OrderPayAction())->execute(
                (new OrderPayRequest($this->request))->getDto()
            );
        } catch (Exception $ex) {
            $this->addError(new Error($ex->getMessage(), $ex->getCode()));
        }

        return null;
    }
}
