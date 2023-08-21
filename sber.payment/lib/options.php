<?php

namespace Sber\Payment;

use Bitrix\Main\Localization\Loc;
use Polus\Options\Fields\CheckboxField;
use Polus\Options\Fields\StringField;
use Polus\Options\Tab;

Loc::loadMessages(__FILE__);

class Options
{
    private static ?Options $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): Options
    {
        if (is_null(static::$instance)) {
            static::$instance = new Options();
        }

        return static::$instance;
    }

    public function getTabs(): array
    {
        return [
            $this->mainTab()
        ];
    }

    protected function mainTab(): Tab
    {
        $tab = new OptionsTab('edit1', Loc::getMessage('SBER_PAYMENT_SETTINGS'), Loc::getMessage('SBER_PAYMENT_MAIN_SETTINGS'));

        $tab->addField(new StringField(Constants::LOGIN_SETTINGS, Loc::getMessage('SBER_PAYMENT_LOGIN')));
        $tab->addField(new StringField(Constants::PASSWORD_SETTINGS, Loc::getMessage('SBER_PAYMENT_PASSWORD')));
        $tab->addField(new StringField(Constants::URL_SETTINGS, Loc::getMessage('SBER_PAYMENT_URL')));
        $tab->addField(new CheckboxField(Constants::IS_TEST_SETTINGS, Loc::getMessage('SBER_PAYMENT_IS_TEST')));

        return $tab;
    }
}
