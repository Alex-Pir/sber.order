<?php

use Bitrix\Main\Loader;
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

Loc::loadMessages(__FILE__);

Loader::includeModule('polus.collaborator');

$arComponentParameters = [
    'PARAMETERS' => [
        'SBER_ORDER_ORDER_ID' => [
            'PARENT' => 'BASE',
            'NAME' => Loc::getMessage('SBER_ORDER_ORDER_ID'),
            'TYPE' => 'INTEGER'
        ],
        'CACHE_TIME' => ['DEFAULT' => 36000000]
    ]
];
