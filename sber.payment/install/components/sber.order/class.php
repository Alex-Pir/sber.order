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

    public function onPrepareComponentParams($arParams): array {
        $arParams['SBER_ORDER_ORDER_ID'] = is_numeric($arParams['SBER_ORDER_ORDER_ID']) && $arParams['SBER_ORDER_ORDER_ID'] > 0
            ? $arParams['SBER_ORDER_ORDER_ID']
            : 0;

        $arParams['CACHE_TIME'] = $arParams['CACHE_TYPE'] !== 'N' ? $arParams['CACHE_TIME'] : 0;

        if (!$arParams['CACHE_TIME']) {
            $arParams['CACHE_TIME'] = 0;
        }

        return $arParams;
    }

    /**
     * @throws LoaderException
     */
    public function executeComponent(): void
    {
        $this->includeModule();

        $this->arResult['orderId'] = $this->arParams['SBER_ORDER_ORDER_ID'] ?? 0;
        $this->arResult['products'] = (new ProductRepository())->getList(['cache' => ['ttl' => $this->arParams['CACHE_TIME']]]);

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
