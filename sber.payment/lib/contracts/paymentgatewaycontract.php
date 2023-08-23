<?php

namespace Sber\Payment\Contracts;

use Sber\Payment\Payment\PaymentData;

interface PaymentGatewayContract
{
    public function configure(): array;

    public function data(PaymentData $data): self;

    public function register(): mixed;

    public function state(): array;

    public function isPaid(): bool;

    public function url(): string;

    public function errorMessage(int $code): string;
}
