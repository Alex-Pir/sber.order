<?php

namespace Sber\Payment\Entity;

use Bitrix\Main\Application;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\DB\SqlQueryException;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\SystemException;
use Exception;
use ReflectionClass;
use ReflectionException;
use Sber\Payment\Contracts\MigrationContract;
use Sber\Payment\Entity\Migrations\ProductsMigration;

class TableManager
{
    public static function install(): void
    {
        $connection = Application::getConnection();

        try {
            $connection->startTransaction();

            foreach (static::getTableClasses() as $class) {
                static::createTable($connection, $class);
            }

            foreach (static::getMigrations() as $migration) {
                $migration->addElements();
            }

            $connection->commitTransaction();
        } catch (Exception $ex) {
            AddMessage2Log($ex->getMessage());

            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $sqlEx) {
                AddMessage2Log($sqlEx->getMessage());
            }
        }
    }

    public static function uninstall(): void
    {
        $connection = Application::getConnection();

        try {
            $connection->startTransaction();

            foreach (array_reverse(static::getTableClasses()) as $class) {
                static::dropTable($connection, $class);
            }

            $connection->commitTransaction();
        } catch (Exception $ex) {
            AddMessage2Log($ex->getMessage());

            try {
                $connection->rollbackTransaction();
            } catch (SqlQueryException $sqlEx) {
                AddMessage2Log($sqlEx->getMessage());
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    public static function getClassInstance(string $class): ?DataManager
    {
        $tableClass = new ReflectionClass($class);

        if (!$tableClass->isSubclassOf(DataManager::class)) {
            return null;
        }

        return $tableClass->newInstance();
    }

    /**
     * @throws ReflectionException
     * @throws SystemException
     * @throws ArgumentException
     */
    protected static function createTable($connection, string $class): void
    {
        $instance = static::getClassInstance($class);

        if (!$connection->isTableExists($instance::getTableName())) {
            $entity = $instance::getEntity();
            $entity->createDbTable();

            if (method_exists($instance, 'createIndexes')) {
                $instance::createIndexes();
            }
        }
    }

    /**
     * @throws ReflectionException
     */
    protected static function dropTable($connection, string $class): void
    {
        $instance = static::getClassInstance($class);

        if ($connection->isTableExists($instance::getTableName())) {
            $connection->dropTable($instance::getTableName());
        }
    }

    protected static function getTableClasses(): array
    {
        return [
            OrderTable::class,
            ProductTable::class,
        ];
    }

    /**
     * @return MigrationContract[]
     */
    protected static function getMigrations(): array
    {
        return [
            new ProductsMigration(),
        ];
    }
}
