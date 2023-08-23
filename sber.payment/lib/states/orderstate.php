<?php

namespace Sber\Payment\States;

use Bitrix\Main\Localization\Loc;
use Exception;
use InvalidArgumentException;
use Sber\Payment\Entity\OrderTable;

Loc::loadMessages(__FILE__);

abstract class OrderState
{
    protected array $allowedTransitions = [];

    public function __construct(
        protected int $orderId
    ) {
    }

    abstract public function canBeChanged(): bool;

    abstract public function value(): string;

    abstract public function humanValue(): string;

    abstract public function canPay(): bool;

    /**
     * @throws Exception
     */
    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()) {
            throw new InvalidArgumentException(
                Loc::getMessage('SBER_ORDER_STATUS_ERROR')
            );
        }

        if (!in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                Loc::getMessage('SBER_ORDER_STATUS_TRANSITION_ERROR', [
                    '#ORDER_ID#' => $this->orderId,
                    '#STATE#' => $state->value()
                ])
            );
        }

        OrderTable::update($this->orderId, ['STATUS' => $state->value()]);
    }
}