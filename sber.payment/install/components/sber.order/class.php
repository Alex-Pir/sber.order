<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Sber\Payment\Repositories\ProductRepository;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

class SberPayment extends CBitrixComponent
{
    protected const SBER_PAYMENT_MODULE = 'sber.payment';
    
    /**
     * @throws LoaderException
     */
    public function executeComponent()
    {
        $this->includeModule();

        $this->arResult['PRODUCTS'] = (new ProductRepository())->getList([]);

        $this->includeComponentTemplate();
    }

    /**
     * @throws LoaderException
     */
    protected function includeModule(): bool
    {
        if (!Loader::includeModule(static::SBER_PAYMENT_MODULE)) {
            throw new LoaderException(Loc::getMessage('SBER_PAYMENT_MODULE_MODULE_NOT_FOUND'));
        }

        return true;
    }
}
