<?php

namespace Test\Integration;

use Src\Adapter\Controller\DeleteFairController;
use Src\Adapter\Controller\UpdateFairController;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Test\Helpers\Traits\WebTestCase;

class UpdateFairDataTest extends DatabaseTestCase
{
    use RandomValueGenerator, WebTestCase;

    public function testUpdateFair()
    {
        $data = $this->randomFairArrayData();
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($data));

        $dataToUpdate['nome_feira'] = $data['nome_feira'] . ' updated';
        $dataToUpdate['logradouro'] = $data['logradouro'] . ' updated';
        $dataToUpdate['bairro'] = $data['bairro'] . ' updated';
        $dataToUpdate['numero'] = null;
        $dataToUpdate['codsubpref'] = $data['codsubpref'] + 10;

        $response = $this->put(new UpdateFairController(), $data['id'], $dataToUpdate);

        $expectedUpdate = array_merge($data, $dataToUpdate);
        $this->assertEquals($expectedUpdate,  json_decode($response->body(), true));
    }

    public function testUpdateWithValidationError()
    {
        $dataToUpdate['codsubpref'] = "text";
        $response = $this->put(new UpdateFairController(), 10, $dataToUpdate);

        $expectedUpdate = [
            "message" => "Validation error",
            "errors" => [
                "codsubpref" => "The Codsubpref must be numeric"
            ]
        ];

        $this->assertEquals($expectedUpdate,  json_decode($response->body(), true));
    }

    public function testUpdateNothing()
    {
        $data = $this->randomFairArrayData();
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($data));
        $response = $this->put(new UpdateFairController(), $data['id'], []);
        $this->assertEquals($data,  json_decode($response->body(), true));
    }

    public function testTryUpdateNonexistentFair()
    {
        $duplicated = $this->randomFairArrayData();

        $response = $this->put(new DeleteFairController(), $duplicated['id'], []);

        $this->assertEquals(404,$response->status()->getCode());
        $this->assertEquals(
            ['message' => "Item not found"],
            json_decode($response->body(), true)
        );
    }
}