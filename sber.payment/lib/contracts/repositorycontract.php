<?php

namespace Sber\Payment\Contracts;

interface RepositoryContract
{
    public function getById(int $id): array;
    public function getList(array $parameters): array;

    public function getByField(string $fieldCode, mixed $value, array $select = ['*'], int $cacheTime = 0): array;
}
