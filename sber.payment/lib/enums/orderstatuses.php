<?php

namespace Sber\Payment\Enums;

use Sber\Payment\States\CancelledOrderState;
use Sber\Payment\States\NewOrderState;
use Sber\Payment\States\OrderState;
use Sber\Payment\States\PaidOrderState;
use Sber\Payment\States\PendingOrderState;

enum OrderStatuses: string
{
    case New = 'new';
    case Pending = 'pending';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function createState(int $orderId): OrderState
    {
        return match ($this) {
            OrderStatuses::New => new NewOrderState($orderId),
            OrderStatuses::Pending => new PendingOrderState($orderId),
            OrderStatuses::Paid => new PaidOrderState($orderId),
            OrderStatuses::Cancelled => new CancelledOrderState($orderId)
        };
    }
}
