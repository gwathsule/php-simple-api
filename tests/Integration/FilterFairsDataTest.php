<?php

namespace Test\Integration;

use Src\Adapter\Controller\FilterFairController;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Test\Helpers\Traits\WebTestCase;

class FilterFairsDataTest extends DatabaseTestCase
{
    use RandomValueGenerator, WebTestCase;

    public function testFilterFairs()
    {
        $data = $this->randomFairArrayData();
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($data));
        $data2 = $data;
        $data2['id'] = $data['id'] + 10;
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($data2));

        $response = $this->get(new FilterFairController(), [
            'distrito' => $data['distrito'],
            'regiao5' => $data['regiao5'],
            'nome_feira' => $data['nome_feira'],
            'bairro' => $data['bairro'],
        ]);

        $expected = [$data, $data2];

        $this->assertEquals(200,$response->status()->getCode());
        $this->assertEquals(
            $expected,
            json_decode($response->body(), true)
        );
    }
}