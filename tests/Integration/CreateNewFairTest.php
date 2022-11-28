<?php

namespace Test\Integration;

use GuzzleHttp\Client;
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
            'exceptions' => false
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
        $incompleteData = $this->removeDataFromArray('distrito', $incompleteData);

        return [
            'create_with_successful' => [
                'data' => $validData,
                'expected' => [
                    'status' => 200,
                    'response' => json_encode($validData)
                ]
            ],
            //'incomplete_data' => [
            //    'data' => json_encode($validData),
            //    'expected' => [
            //        'status_response' => 200,
            //        'data_response' => json_encode($validData)
            //    ]
            //]
        ];
    }

    private function removeDataFromArray(string $data, array $fullData): array
    {
        $key = array_search($data, $fullData);
        if($key!==false){
            unset($fullData[$key]);
        }

        return $fullData;
    }
}