<?php

namespace Sber\Payment\Payment;

use Sber\Payment\ValueObjects\Price;

final class PaymentData
{
    public function __construct(
        public string $id,
        public ?Price $price = null,
    ) {
    }
}
