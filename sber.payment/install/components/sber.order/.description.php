<?php

use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

$arComponentDescription = [
    'NAME' => Loc::getMessage('SBER_ORDER_COMPONENT_NAME'),
    'DESCRIPTION' => Loc::getMessage('SBER_ORDER_COMPONENT_DESCRIPTION'),
    'CACHE_PATH' => 'Y',
    'PATH' => [
        'ID' => 'polus',
        'NAME' => Loc::getMessage('SBER_ORDER_COMPONENT_PATH')
    ],
];