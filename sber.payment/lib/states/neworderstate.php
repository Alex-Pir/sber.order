<?php

namespace Sber\Payment\States;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class NewOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PendingOrderState::class,
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'new';
    }

    public function humanValue(): string
    {
        return Loc::getMessage('SBER_ORDER_STATE_NEW');
    }

    public function canPay(): bool
    {
        return false;
    }
}
