<?php

namespace Src\Infra\Database;

use PDO;

class SqliteConnection
{
    public static function connect(): PDO
    {
        return new PDO("sqlite:" . getenv('SQLITE_PATH'));
    }
}