<?php

namespace Sber\Payment\Controllers\Order\Dto;

use Sber\Payment\Entity\OrderTable;
use Sber\Payment\enums\OrderStatuses;
use Sber\Payment\Repositories\ProductRepository;
use Sber\Payment\Support\Traits\Makeable;
use Sber\Payment\ValueObjects\Price;

class OrderDto
{
    use Makeable;

    public function __construct(
        public readonly string $orderId,
        public readonly string $userLastName,
        public readonly string $userName,
        public readonly string $userSecondName,
        public readonly int $productId,
        public readonly int $amount,
        public readonly int|float $price,
        public readonly string $status,
    ) {
    }

    public static function fromArray(array $fields): self
    {
        $product = [];

        if (isset($fields['product_id'])) {
            $product = (new ProductRepository())->getById($fields['product_id']);
        }

        return static::make(
            $fields['order_id'] ?? '',
            $fields['user_last_name'] ?? '',
            $fields['user_second_name'] ?? '',
            $fields['user_name'] ?? '',
            $fields['product_id'] ?? 0,
            $fields['amount'] ?? 0,
            $product['ORIGINAL_PRICE'] ?? 0,
            $fields['status'] ?? OrderStatuses::New->value,
        );
    }

    public static function fromDbArray(array $fields): self
    {
        return static::make(
            $fields[OrderTable::ORDER_ID] ?? '',
            $fields[OrderTable::USER_LAST_NAME] ?? '',
            $fields[OrderTable::USER_NAME] ?? '',
            $fields[OrderTable::USER_SECOND_NAME] ?? '',
            $fields[OrderTable::PRODUCT_ID] ?? 0,
            $fields[OrderTable::AMOUNT] ?? 0,
            isset($fields[OrderTable::PRICE]) ? Price::make($fields[OrderTable::PRICE])->value() : 0,
            $fields[OrderTable::STATUS] ?? OrderStatuses::New->value,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            OrderTable::ORDER_ID => $this->orderId,
            OrderTable::USER_LAST_NAME => $this->userLastName,
            OrderTable::USER_NAME => $this->userName,
            OrderTable::USER_SECOND_NAME => $this->userSecondName,
            OrderTable::PRODUCT_ID => $this->productId,
            OrderTable::AMOUNT => $this->amount,
            OrderTable::PRICE => $this->price,
            OrderTable::STATUS => $this->status,
        ]);
    }
}