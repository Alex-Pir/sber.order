<?php

namespace Sber\Payment\Entity\Migrations;

use Bitrix\Main\ArgumentException;
use Bitrix\Main\SystemException;
use Sber\Payment\Contracts\MigrationContract;
use Sber\Payment\Entity\ProductTable;

class ProductsMigration implements MigrationContract
{
    protected array $products = [
        [
            ProductTable::NAME => 'Кроссовки',
            ProductTable::PRICE => 200.24,
        ],
        [
            ProductTable::NAME => 'Ботинки',
            ProductTable::PRICE => 250,
        ],
        [
            ProductTable::NAME => 'Куртка',
            ProductTable::PRICE => 500,
        ],
    ];

    /**
     * @throws SystemException
     * @throws ArgumentException
     */
    public function addElements(): void
    {
        ProductTable::addMulti($this->products);
    }
}