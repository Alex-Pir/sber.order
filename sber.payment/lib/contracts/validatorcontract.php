<?php

namespace Sber\Payment\Contracts;

interface ValidatorContract
{
    public function validate(mixed $parameter): mixed;
    public static function key(): string;
}
