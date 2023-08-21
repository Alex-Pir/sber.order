<?php

namespace Sber\Payment\Entity;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\Type\DateTime;
use Sber\Payment\ValueObjects\Price;

class ProductTable extends DataManager
{
    public const ID = 'ID';
    public const NAME = 'NAME';
    public const PRICE = 'PRICE';
    public const DATE_CREATE = 'DATE_CREATE';
    public const DATE_UPDATE = 'DATE_UPDATE';

    public static function getTableName(): string
    {
        return 'app_products';
    }

    public static function getMap(): array
    {
        return [
            new IntegerField(static::ID, [
                'primary' => true,
                'autocomplete' => true,
            ]),
            new StringField(static::NAME, [
                'title' => Loc::getMessage('SBER_PAYMENT_TABLE_USER_NAME'),
                'required' => true,
            ]),
            new IntegerField(static::PRICE, [
                'required' => true,
            ]),
            new DatetimeField(static::DATE_CREATE, [
                'title' => Loc::getMessage('SBER_PAYMENT_TABLE_DATE_CREATE'),
                'required' => true,
                'default_value' => fn() => new DateTime()
            ]),
            new DatetimeField(static::DATE_UPDATE, [
                'title' => Loc::getMessage('SBER_PAYMENT_TABLE_DATE_UPDATE'),
                'required' => true
            ]),
        ];
    }

    public static function onBeforeAdd(Event $event): EventResult
    {
        return static::onBeforeSave($event, static::EVENT_ON_BEFORE_ADD);
    }

    public static function onBeforeUpdate(Event $event): EventResult
    {
        return static::onBeforeSave($event, static::EVENT_ON_BEFORE_UPDATE);
    }

    public static function onBeforeSave(Event $event, string $type): EventResult
    {
        $result = new EventResult();

        $modifiedFields = [];
        $modifiedFields[static::DATE_UPDATE] = new DateTime();

        $fields = $event->getParameters()['fields'];

        if (isset($fields[static::PRICE])) {
            $modifiedFields[static::PRICE] = $fields[static::PRICE] <= 0 ? 0 : Price::make($fields[static::PRICE])->raw();
        }

        $result->modifyFields($modifiedFields);

        return $result;
    }
}