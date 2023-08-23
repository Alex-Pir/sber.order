<?php

namespace Sber\Payment\States;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pending';
    }

    public function humanValue(): string
    {
        return Loc::getMessage('SBER_ORDER_STATUS_PENDING');
    }

    public function canPay(): bool
    {
        return true;
    }
}
