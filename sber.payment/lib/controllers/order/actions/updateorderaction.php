<?php

namespace Sber\Payment\Controllers\Order\Actions;

use Sber\Payment\Entity\OrderTable;

class UpdateOrderAction
{
    public function execute(int $id, array $fields): void
    {
        OrderTable::update($id, $fields);
    }
}
