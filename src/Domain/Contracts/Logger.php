<?php

namespace Src\Domain\Contracts;

interface Logger
{
    public function log(string $json);
}