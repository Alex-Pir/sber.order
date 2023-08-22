<?php

namespace Sber\Payment\Controllers\Order\Actions;

use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\SystemException;
use Psr\Container\NotFoundExceptionInterface;
use Sber\Payment\Contracts\PaymentGatewayContract;
use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Payment\PaymentData;
use Sber\Payment\ValueObjects\Price;

class OrderPayAction
{
    /**
     * @throws SystemException
     * @throws NotFoundExceptionInterface
     */
    public function execute(OrderDto $orderDto): string
    {
        $serviceLocator = ServiceLocator::getInstance();

        if (!$serviceLocator->has(PaymentGatewayContract::class)) {
            throw new SystemException('Невозможно осуществить оплату');
        }

        $paymentData = new PaymentData(
            $orderDto->orderId,
            Price::make($orderDto->price)
        );

        return $serviceLocator->get(PaymentGatewayContract::class)
            ->data($paymentData)
            ->register();
    }
}
