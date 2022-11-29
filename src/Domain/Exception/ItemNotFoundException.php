<?php

namespace Src\Domain\Exception;

use Exception;
use Throwable;

class ItemNotFoundException extends Exception
{
    public function __construct(int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct("Item not found", $code, $previous);
    }
}