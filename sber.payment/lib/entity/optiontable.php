<?php
namespace Sber\Payment\Entity;

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\StringField;
use Bitrix\Main\ORM\Fields\TextField;
use Bitrix\Main\ORM\Fields\Validators\LengthValidator;

class OptionTable extends DataManager
{
    public static function getTableName(): string
    {
        return 'b_option';
    }

    public static function getMap(): array
    {
        return [
            new StringField(
                'MODULE_ID',
                [
                    'primary' => true,
                    'validation' => [__CLASS__, 'validateModuleId']
                ]
            ),
            new StringField(
                'NAME',
                [
                    'primary' => true,
                    'validation' => [__CLASS__, 'validateName']
                ]
            ),
            new TextField('VALUE'),
            new StringField(
                'DESCRIPTION',
                [
                    'validation' => [__CLASS__, 'validateDescription']
                ]
            ),
            new StringField(
                'SITE_ID',
                [
                    'validation' => [__CLASS__, 'validateSiteId']
                ]
            ),
        ];
    }

    /**
     * Returns validators for MODULE_ID field.
     *
     * @return array
     */
    public static function validateModuleId(): array
    {
        return [
            new LengthValidator(null, 50),
        ];
    }

    /**
     * Returns validators for NAME field.
     *
     * @return array
     */
    public static function validateName(): array
    {
        return [
            new LengthValidator(null, 100),
        ];
    }

    /**
     * Returns validators for DESCRIPTION field.
     *
     * @return array
     */
    public static function validateDescription(): array
    {
        return [
            new LengthValidator(null, 255),
        ];
    }


    public static function validateSiteId(): array
    {
        return [
            new LengthValidator(null, 2),
        ];
    }
}