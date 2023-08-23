<?php

namespace Sber\Payment\Controllers\Order\Requests;

use Sber\Payment\Controllers\Order\Dto\OrderDto;
use Sber\Payment\Support\Requests\BaseRequest;

class OrderCreateRequest extends BaseRequest
{
    protected function rules(): array
    {
        return [
            'user_last_name' => ['type' => 'string', 'required' => true,],
            'user_name' => ['type' => 'string', 'required' => true,],
            'user_second_name' => ['type' => 'string',],
            'product_id' => ['type' => 'integer', 'required' => true, 'min' => 1,],
            'amount' => ['type' => 'integer', 'required' => true, 'min' => 1,],
        ];
    }

    public function getDto(): OrderDto
    {
        return OrderDto::fromArray($this->validated());
    }
}
