<?php

namespace Sber\Payment\States;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CancelledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'paid';
    }

    public function humanValue(): string
    {
        return Loc::getMessage('SBER_ORDER_STATUS_PAID');
    }

    public function canPay(): bool
    {
        return false;
    }
}
