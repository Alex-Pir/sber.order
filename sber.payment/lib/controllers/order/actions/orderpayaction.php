<?php

namespace Sber\Payment\Controllers\Order\Actions;

use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Payment\Gateway\SberGateway;
use Sber\Payment\Payment\PaymentData;
use Sber\Payment\ValueObjects\Price;

class OrderPayAction
{
    public function execute(OrderDto $orderDto): string
    {
        $paymentGateway = new SberGateway();

        $paymentData = new PaymentData(
            $orderDto->orderId,
            Price::make($orderDto->price)
        );

        return $paymentGateway->data($paymentData)
            ->register();
    }
}