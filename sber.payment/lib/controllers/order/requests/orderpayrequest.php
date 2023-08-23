<?php

namespace Sber\Payment\Controllers\Order\Requests;

use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Entity\OrderTable;
use Sber\Payment\Support\Requests\BaseRequest;

class OrderPayRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'order_id' => ['type' => 'integer', 'min' => 1, 'exist' => OrderTable::class]
        ];
    }

    public function getDto(): OrderDto
    {
        return OrderDto::fromDbArray($this->validated()['order_id']);
    }
}
