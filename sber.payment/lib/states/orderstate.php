<?php

namespace Sber\Payment\States;

use InvalidArgumentException;
use Sber\Payment\Entity\OrderTable;

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

    public function transitionTo(OrderState $state): void
    {
        if (!$this->canBeChanged()) {
            throw new InvalidArgumentException(
                'Status can`t be changed'
            );
        }

        if (!in_array(get_class($state), $this->allowedTransitions)) {
            throw new InvalidArgumentException(
                "No transition for order {$this->orderId} to {$state->value()}"
            );
        }

        OrderTable::update($this->orderId, ['STATUS' => $state->value()]);
    }
}