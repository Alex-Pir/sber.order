<?php

namespace Sber\Payment\ValueObjects;

use Bitrix\Main\Localization\Loc;
use InvalidArgumentException;
use Sber\Payment\Support\Traits\Makeable;
use Stringable;

Loc::loadMessages(__FILE__);

class Price implements Stringable
{
    use Makeable;

    private array $currencies = [
        'RUB' => '₽'
    ];

    public function __construct(
        private readonly int $value,
        private readonly string $currency = 'RUB',
        private readonly int $precision = 100
    ) {
        if ($value < 0) {
            throw new InvalidArgumentException(Loc::getMessage('SBER_PAYMENT_PRICE_ZERO_EXCEPTION'));
        }

        if (!isset($this->currencies[$currency])) {
            throw new InvalidArgumentException(Loc::getMessage('SBER_PAYMENT_PRICE_CURRENCY_EXCEPTION'));
        }
    }

    public function raw(): int
    {
        return $this->value * $this->precision;
    }

    public function current(): int
    {
        return $this->value;
    }

    public function value(): float|int
    {
        return $this->value / $this->precision;
    }

    public function currency(): string
    {
        return $this->currency;
    }

    public function symbol(): string
    {
        return$this->currencies[$this->currency];
    }

    public function __toString(): string
    {
        return number_format($this->value(), 0, ',', ' ')
            . ' ' . $this->symbol();
    }
}