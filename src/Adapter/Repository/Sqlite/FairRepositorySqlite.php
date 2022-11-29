<?php

namespace Src\Adapter\Repository\Sqlite;

use Src\Domain\Entity\Fair\Fair;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Repository\FairRepository;
use SQLite3;

class FairRepositorySqlite extends SqliteRepository implements FairRepository
{
    private const TABLE_NAME = 'fairs';

    public function __construct()
    {
        $this->createTableIfNotExists($this->getDatabase());
    }

    public function save(Fair $fair): void
    {
        $db = $this->getDatabase();
        $data = [
            'id' => $fair->get('id'),
            'long' => $fair->get('long'),
            'lat' => $fair->get('lat'),
            'setcens' => $fair->get('setcens'),
            'areap' => $fair->get('areap'),
            'coddist' => $fair->get('coddist'),
            'distrito' => $fair->get('distrito'),
            'codsubpref' => $fair->get('codsubpref'),
            'subprefe' => $fair->get('subprefe'),
            'regiao5' => $fair->get('regiao5'),
            'regiao8' => $fair->get('regiao8'),
            'nome_feira' => $fair->get('nome_feira'),
            'registro' => $fair->get('registro'),
            'logradouro' => $fair->get('logradouro'),
            'numero' => $fair->get('numero'),
            'bairro' => $fair->get('bairro'),
            'referencia' => $fair->get('referencia'),
        ];
        $this->insert($db, self::TABLE_NAME, $data);
        $db->close();
    }

    public function update(array $attributes, int $id): Fair
    {
        $db = $this->getDatabase();
        $this->updateById($db, self::TABLE_NAME, $attributes, $id);
        $updatedData = $this->getById($db, self::TABLE_NAME, $id);
        $db->close();
        return FairFactory::oneFromArray($updatedData);
    }

    public function delete(int $id): bool
    {
        $db = $this->getDatabase();
        $this->deleteById($db, self::TABLE_NAME, $id);
        $db->close();
        return true;
    }

    public function find(int $id): ?Fair
    {
        $db = $this->getDatabase();
        $data = $this->getById($db, self::TABLE_NAME, $id);
        $db->close();
        if(is_null($data)) {
            return null;
        }
        return FairFactory::oneFromArray($data);
    }

    public function getBy(string $attribute, string $value): array
    {
        // TODO: Implement getBy() method.
    }


    private function createTableIfNotExists(SQLite3 $conn)
    {
        $exec = "CREATE TABLE IF NOT EXISTS ". self::TABLE_NAME. " (".
            "id INTEGER PRIMARY KEY, ".
            "long TEXT, ".
            "lat TEXT, ".
            "setcens TEXT, ".
            "areap TEXT, ".
            "coddist INTEGER, ".
            "distrito TEXT, ".
            "codsubpref INTEGER, ".
            "subprefe TEXT, ".
            "regiao5 TEXT, ".
            "regiao8 TEXT, ".
            "nome_feira TEXT, ".
            "registro TEXT, ".
            "logradouro TEXT, ".
            "numero TEXT, ".
            "bairro TEXT, ".
            "referencia TEXT".
            ");";
        $conn->exec($exec);
    }
}