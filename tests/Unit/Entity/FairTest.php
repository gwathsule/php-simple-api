<?php

namespace Entity;

use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;

class FairTest extends DatabaseTestCase
{
    use RandomValueGenerator;

    public function testCreate()
    {
        $reposiory = new FairRepositorySqlite();

        $randomData = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($randomData);
        $reposiory->save($fair);
        $savedFair = $reposiory->find($randomData['id']);

        $this->assertNotNull($savedFair);
        foreach (array_keys($randomData) as $attribute) {
            $this->assertEquals($randomData[$attribute], $savedFair->get($attribute));
        }
    }
}