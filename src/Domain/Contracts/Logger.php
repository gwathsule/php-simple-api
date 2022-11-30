<?php

namespace Src\Domain\Contracts;

use Throwable;

interface Logger
{
    public function logException(Throwable $exception): void;

    public function logInfo(string $title, array $data): void;
}