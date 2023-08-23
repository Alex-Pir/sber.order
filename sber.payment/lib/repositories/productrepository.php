<?php

namespace Sber\Payment\Repositories;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\SystemException;
use Sber\Payment\Contracts\RepositoryContract;
use Sber\Payment\Entity\ProductTable;
use Sber\Payment\ValueObjects\Price;

class ProductRepository implements RepositoryContract
{
    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getById(int $id): array
    {
        $product = ProductTable::getById($id)->fetch();

        if ($product) {
            $product['HUMAN_PRICE'] = (string) Price::make($product[ProductTable::PRICE]);
            $product['ORIGINAL_PRICE'] = Price::make($product[ProductTable::PRICE])->value();
        }

        return $product;
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getList(array $parameters): array
    {
        $products = ProductTable::getList($parameters);

        while ($product = $products->fetch()) {
            $product['HUMAN_PRICE'] = (string) Price::make($product[ProductTable::PRICE]);
            $product['ORIGINAL_PRICE'] = Price::make($product[ProductTable::PRICE])->value();

            $result[] = $product;
        }

        return $result ?? [];
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function getByField(string $fieldCode, mixed $value, array $select = ['*'], int $cacheTime = 0): array
    {
        return ProductTable::getList([
            'filter' => ["=$fieldCode" => $value],
            'select' => $select,
            'cache' => ['ttl' => $cacheTime],
        ])->fetch();
    }
}
