<?php

namespace Sber\Payment\Entity;

use Bitrix\Main\Entity\Event;
use Bitrix\Main\Entity\EventResult;
use Bitrix\Main\Entity\ReferenceField;
use Bitrix\Main\Entity\Validator\RegExp;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\DatetimeField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\Type\DateTime;
use Bitrix\UI\NotificationManager\Helpers\Uuid;
use Exception;
use Sber\Payment\Entity\Fields\PriceField;
use Sber\Payment\ValueObjects\Price;

Loc::loadMessages(__FILE__);

class OrderTable extends DataManager
{
    public const ID = 'ID';
    public const ORDER_ID = 'ORDER_ID';
    public const USER_LAST_NAME = 'USER_LAST_NAME';
    public const USER_NAME = 'USER_NAME';
    public const USER_SECOND_NAME = 'USER_SECOND_NAME';
    public const PRODUCT_ID = 'PRODUCT_ID';
    public const AMOUNT = 'AMOUNT';
    public const PRICE = 'PRICE';
    public const STATUS = 'STATUS';
    public const DATE_CREATE = 'DATE_CREATE';
    public const DATE_UPDATE = 'DATE_UPDATE';

    public static function getTableName(): string
    {
        return 'app_orders';
    }

    public static function getMap(): array
    {
        return [
            (new IntegerField(static::ID, [
                'primary' => true,
                'autocomplete' => true,
            ])),
            new StringField(static::ORDER_ID, [
                'required' => true,
            ]),
            new StringField(static::USER_LAST_NAME, [
                'required' => true,
            ]),
            new StringField(static::USER_NAME, [
                'required' => true,
            ]),
            new StringField(static::USER_SECOND_NAME),
            new IntegerField(static::PRODUCT_ID, [
                'validation' => [__CLASS__, 'positiveIntegerValidator'],
                'required' => true,
            ]),
            new IntegerField(static::AMOUNT, [
                'validation' => [__CLASS__, 'positiveIntegerValidator'],
                'required' => true,
            ]),
            new IntegerField(static::PRICE, [
                'validation' => [__CLASS__, 'positiveIntegerValidator'],
                'required' => true,
            ]),
            new StringField(static::STATUS, [
                'required' => true,
            ]),
            new DatetimeField(static::DATE_CREATE, [
                'required' => true,
                'default_value' => fn () => new DateTime()
            ]),
            new DatetimeField(static::DATE_UPDATE, [
                'required' => true
            ]),
            new ReferenceField(
                'PRODUCT',
                ProductTable::class,
                ['=this.' . static::PRODUCT_ID => 'ref.' . ProductTable::ID]
            ),
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

        if ($type === static::EVENT_ON_BEFORE_ADD) {
            $modifiedFields[static::ORDER_ID] = static::uuid();
        }

        $result->modifyFields($modifiedFields);

        return $result;
    }

    public static function positiveIntegerValidator(): array
    {
        return [
            new RegExp(
                '/^\d+$/',
                ''
            )
        ];
    }

    /**
     * @throws Exception
     */
    protected static function uuid(): string
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        );
    }
}
