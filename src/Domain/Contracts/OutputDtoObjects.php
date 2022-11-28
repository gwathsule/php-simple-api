<?php

namespace Src\Domain\Contracts;

interface OutputDtoObjects extends InputDtoObjects
{
    public function toJson(): string;
}