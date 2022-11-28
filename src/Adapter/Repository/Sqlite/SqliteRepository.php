<?php

namespace Src\Adapter\Repository\Sqlite;

use SQLite3;
use Exception;
use Src\Adapter\Exception\SqliteException;

class SqliteRepository
{
    protected function getDatabase(): SQLite3
    {
        return new SQLite3(getenv('SQLITE_PATH'));
    }

    protected function insert(SQLite3 $db, string $table, array $data)
    {
        $columns = implode(',', array_keys($data));
        $values = array_map(fn($value) => gettype($value) == "string" ? "'$value'" : $value, $data);
        $values = implode(', ', $values);
        $query = "INSERT INTO $table($columns) VALUES ($values)";
        try {
            $db->exec($query);
        } catch (Exception $ex) {
            throw new SqliteException($db, 0, $ex);
        }
    }

    protected function getById(SQLite3 $db, string $table, int $id): ?array
    {
        try {

            $stm = $db->prepare("SELECT * FROM $table WHERE id = ?");
            $stm->bindValue(1, $id, SQLITE3_INTEGER);
            $res = $stm->execute();
        } catch (Exception $ex) {
            throw new SqliteException($db, 0, $ex);
        }
        $columns = $res->fetchArray(SQLITE3_ASSOC);
        if(! $columns) {
            return null;
        }
        return $columns;
    }
}