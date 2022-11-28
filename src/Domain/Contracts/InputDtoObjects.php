<?php

namespace Src\Domain\Contracts;

interface InputDtoObjects
{
    public static function buildFromArray(array $attributes) : self;

    public function toArray(): array;
}