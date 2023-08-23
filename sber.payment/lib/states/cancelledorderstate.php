<?php

namespace Sber\Payment\States;

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class CancelledOrderState extends OrderState
{
    protected array $allowedTransitions = [

    ];

    public function canBeChanged(): bool
    {
        return false;
    }

    public function value(): string
    {
        return 'cancelled';
    }

    public function humanValue(): string
    {
        return Loc::getMessage('SBER_ORDER_STATE_CANCELLED');
    }

    public function canPay(): bool
    {
        return false;
    }
}
