<?php

namespace Sber\Payment\Repositories;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\NotSupportedException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Sber\Payment\Contracts\RepositoryContract;
use Sber\Payment\Entity\OrderTable;

class OrderRepository implements RepositoryContract
{
    /**
     * @throws NotSupportedException
     */
    public function getById(int $id): array
    {
        //Не писал за ненадобностью.
        // Вообще, нужно разделить интерфейсы в таком случае по принципу разделения интерфейсов.
        throw new NotSupportedException();
    }

    /**
     * @throws NotSupportedException
     */
    public function getList(array $parameters): array
    {
        throw new NotSupportedException();
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getByField(string $fieldCode, mixed $value, array $select = ['*'], int $cacheTime = 0): array
    {
        return OrderTable::getList([
            'filter' => ["=$fieldCode" => $value],
            'select' => $select,
            'cache' => ['ttl' => $cacheTime],
        ])->fetch();
    }
}
