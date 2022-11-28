<?php

namespace Src\Adapter\Exception;

use Exception;
use Throwable;
use SQLite3;

class SqliteException extends Exception
{
    private SQLite3 $conn;

    public function __construct(SQLite3 $db, int $code = 0, ?Throwable $previous = null)
    {
        $this->conn = $db;
        $message = "Error when trying to connect SQLite database.";
        parent::__construct($message, $code, $previous);
    }

    public function getConnection(): SQLite3
    {
        return $this->conn;
    }
}