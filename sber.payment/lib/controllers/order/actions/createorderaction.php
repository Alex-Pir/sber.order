<?php

namespace Sber\Payment\Controllers\Order\Actions;

use Exception;
use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Entity\OrderTable;

class CreateOrderAction
{
    /**
     * @throws Exception
     */
    public function execute(OrderDto $orderDto): array
    {
        $result = OrderTable::add($orderDto->toArray());

        return ['order_id' => $result->getId()];
    }
}
