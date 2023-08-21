<?php

namespace Sber\Payment\Contracts;

interface RepositoryContract
{
    public function getById(int $id): array;
    public function getList(array $parameters): array;
}
