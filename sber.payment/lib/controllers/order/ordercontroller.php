<?php

namespace Sber\Payment\Controllers\Order;

use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Error;
use Exception;
use Sber\Payment\Controllers\Order\Actions\CreateOrderAction;
use Sber\Payment\Controllers\Order\Actions\OrderPayAction;
use Sber\Payment\Controllers\Order\Actions\UpdateOrderAction;
use Sber\Payment\Controllers\Order\Requests\OrderCreateRequest;
use Sber\Payment\Controllers\Order\Requests\OrderPayRequest;
use Sber\Payment\Entity\OrderTable;

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

    public function payAction(): array|null
    {
        try {
            $orderDto = (new OrderPayRequest($this->request))->getDto();

            $link = (new OrderPayAction())->execute($orderDto);

            (new UpdateOrderAction())->execute($orderDto->id, [OrderTable::PAYMENT_LINK => $link]);

            return ['payment_link' => $link];
        } catch (Exception $ex) {
            $this->addError(new Error($ex->getMessage(), $ex->getCode()));
        }

        return null;
    }
}
