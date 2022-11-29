<?php

namespace Test\Integration;

use GuzzleHttp\Client;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;

class CreateNewFairTest extends DatabaseTestCase
{
    use RandomValueGenerator;

    private Client $client;

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => 'http://nginx',
            'http_errors' => false
        ]);
        parent::setUp();
    }

    /**
     * @dataProvider providerFairData
     */
    public function testCreate(array $data, array $expected)
    {
        $response = $this->client->post('/fair', [
            'json' => $data
        ]);
        $this->assertEquals($expected['status'], $response->getStatusCode());
        $this->assertEquals($expected['response'], json_decode($response->getBody()->getContents(), true));
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