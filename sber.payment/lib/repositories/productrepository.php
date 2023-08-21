<?php

namespace Sber\Payment\Repositories;

use Sber\Payment\Contracts\RepositoryContract;
use Sber\Payment\Entity\ProductTable;
use Sber\Payment\ValueObjects\Price;

class ProductRepository implements RepositoryContract
{
    public function getById(int $id): array
    {
        $product = ProductTable::getById($id)->fetch();

        if ($product) {
            $product['HUMAN_PRICE'] = (string) Price::make($product[ProductTable::PRICE]);
            $product['ORIGINAL_PRICE'] = Price::make($product[ProductTable::PRICE])->value();
        }

        return $product;
    }

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
}
