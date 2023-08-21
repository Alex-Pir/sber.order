<?php

namespace Sber\Payment\Support\Traits;

use Bitrix\Main\Config\Option;
use Bitrix\Main\Localization\Loc;
use Sber\Payment\Constants;
use Sber\Payment\Entity\OptionTable;
use Exception;

Loc::loadMessages(__FILE__);

trait HasModuleOption
{
    public static function getAllModuleOptions(): array
    {
        $options = OptionTable::getList([
            'filter' => [
                'MODULE_ID' => Constants::MODULE_ID
            ],
            'select' => ['NAME', 'VALUE'],
            'cache' => ['ttl' => Constants::CACHE_TIME]
        ])->fetchAll();

        foreach ($options as $option) {
            $result[$option['NAME']] = $option['VALUE'];
        }

        return $result ?? [];
    }

    public static function getModuleOption(string $code, $default = null): ?string
    {
        return static::getOtherModuleOption(Constants::MODULE_ID, $code, $default);
    }

    public static function getOtherModuleOption(string $moduleId, string $code, $default = null): ?string
    {
        try {
            return Option::get($moduleId, $code, $default);
        } catch (Exception $ex) {
            AddMessage2Log($ex->getMessage());
            return $default;
        }
    }

    public static function getModuleOptionArray(string $code, array $default = [], string $separator = ','): array
    {
        try {
            $result = Option::get(Constants::MODULE_ID, $code, null);

            if ($result == null) {
                return $default;
            }

            return explode($separator, Option::get(Constants::MODULE_ID, $code, $default));
        } catch (Exception $ex) {
            AddMessage2Log($ex->getMessage());
            return $default;
        }
    }
}
