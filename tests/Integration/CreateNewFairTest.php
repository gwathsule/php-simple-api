<?php

namespace Test\Integration;

use PHPUnit\Framework\TestCase;

class CreateNewFairTest extends TestCase
{
    //use RandomValueGenerator;

    /**
     * @dataprovider
     */
    public function testCreate()
    {

    }

    public function dataFairProvider()
    {
        $validData = $this->randomFairArrayData();
        $incompleteData = $this->randomFairArrayData();
        $incompleteData = $this->removeDataFromArray('distrito', $incompleteData);

        return [
            'create_with_successful' => [
                'data' => json_encode($validData),
                'expected' => [
                    'status_response' => 200,
                    'data_response' => json_encode($validData)
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