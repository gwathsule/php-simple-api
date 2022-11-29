<?php

namespace Test\Integration;

use Src\Adapter\Controller\CreateFairController;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Test\Helpers\Traits\WebTestCase;

class CreateNewFairTest extends DatabaseTestCase
{
    use RandomValueGenerator, WebTestCase;

    /**
     * @dataProvider providerFairData
     */
    public function testCreate(array $data, array $expected)
    {
        $response = $this->post(new CreateFairController(), $data);
        $this->assertEquals($expected['status'], $response->status()->getCode());
        $this->assertEquals($expected['response'], json_decode($response->body(), true));
    }

    public function testTrySaveDuplicatedFair()
    {
        $duplicated = $this->randomFairArrayData();
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($duplicated));

        $response = $this->post(new CreateFairController(), $duplicated);

        $this->assertEquals(409,$response->status()->getCode());
        $this->assertEquals(
            ["message" => "The register id {$duplicated["id"]} is duplicated"],
            json_decode($response->body(), true)
        );
    }

    public function providerFairData()
    {
        $validData = $this->randomFairArrayData();
        $incompleteData = $this->randomFairArrayData();
        unset($incompleteData['distrito']);

        return [
            'create_with_successful' => [
                'data' => $validData,
                'expected' => [
                    'status' => 200,
                    'response' => $validData
                ]
            ],
            'incomplete_data' => [
                'data' => $incompleteData,
                'expected' => [
                    'status' => 400,
                    'response' => [
                        "message" => "Validation error",
                        "errors" => [
                            "distrito" => "The Distrito is required"
                        ]
                    ]
                ]
            ]
        ];
    }
}