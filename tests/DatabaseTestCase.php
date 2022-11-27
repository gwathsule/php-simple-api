<?php

namespace Test;

use PHPUnit\Framework\TestCase;
use SQLite3;

class DatabaseTestCase extends TestCase
{
    protected function tearDown(): void
    {
        $db = new SQLite3(getenv('SQLITE_PATH'));
        $db->exec("DROP TABLE IF EXISTS fairs");
        parent::tearDown();
    }
}