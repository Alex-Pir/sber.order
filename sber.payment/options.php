<?php

use Bitrix\Main\Loader;
use Bitrix\Main\LoaderException;
use Bitrix\Main\Localization\Loc;
use Polus\Options\ModuleSettings;
use Sber\Payment\Options;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
	die();
}

Loc::loadMessages(__FILE__);

global $USER, $APPLICATION;

$moduleId = 'sber.payment';

if (!defined('ADMIN_MODULE_NAME') || ADMIN_MODULE_NAME !== $moduleId) {
    define('ADMIN_MODULE_NAME', $moduleId);
}

if (!$USER->IsAdmin()) {
    $APPLICATION->AuthForm(Loc::getMessage('ACCESS_DENIED'));
    return false;
}

try {
    if (!Loader::includeModule($moduleId)) {
        ShowError(Loc::getMessage('SBER_PAYMENT_OPTION_E_MODULE_NOT_INSTALL'));
    }

    $moduleSettings = ModuleSettings::getInstance();
    $moduleSettings->setModuleId($moduleId);

    $options = Options::getInstance();
    $tabs = $options->getTabs();

    foreach ($tabs as $tab) {
        $moduleSettings->addTab($tab);
    }

    $moduleSettings->viewSettingsPage();
} catch (LoaderException $ex) {
    ShowError($ex->getMessage());
}
