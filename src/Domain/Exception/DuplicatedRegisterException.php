<?php

namespace Src\Domain\Exception;

use Exception;
use Throwable;

class DuplicatedRegisterException extends Exception
{
    public function __construct(int $id, int $code = 0, ?Throwable $previous = null)
    {
        $message = "The register id $id is duplicated";
        parent::__construct($message, $code, $previous);
    }
}