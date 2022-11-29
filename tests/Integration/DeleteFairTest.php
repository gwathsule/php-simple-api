<?php

namespace Test\Integration;

use Src\Adapter\Controller\DeleteFairController;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Test\Helpers\Traits\WebTestCase;

class DeleteFairTest extends DatabaseTestCase
{
    use RandomValueGenerator, WebTestCase;

    public function testDeleteFair()
    {
        $data = $this->randomFairArrayData();
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($data));

        $response = $this->delete(new DeleteFairController(), $data['id']);

        $this->assertEquals(200,$response->status()->getCode());
        $this->assertEquals(
            ["deleted"],
            json_decode($response->body(), true)
        );
    }

    public function testTryDeleteNonexistentFair()
    {
        $data = $this->randomFairArrayData();

        $response = $this->delete(new DeleteFairController(), $data['id']);

        $this->assertEquals(404,$response->status()->getCode());
        $this->assertEquals(
            ['message' => "Item not found"],
            json_decode($response->body(), true)
        );
    }
}