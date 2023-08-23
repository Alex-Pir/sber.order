<?php

namespace Sber\Payment\Controllers\Order\Actions;

use Exception;
use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Entity\OrderTable;
use Sber\Payment\Enums\OrderStatuses;
use Sber\Payment\States\PendingOrderState;

class CreateOrderAction
{
    /**
     * @throws Exception
     */
    public function execute(OrderDto $orderDto): array
    {
        $result = OrderTable::add($orderDto->toArray());

        //TODO Тут должны быть проверки на доступность товара, количество товара, пользователя, сделавшего заказ

        OrderStatuses::from($orderDto->status)
            ->createState($result->getId())
            ->transitionTo(new PendingOrderState($orderDto->id));

        return ['order_id' => $result->getId()];
    }
}
