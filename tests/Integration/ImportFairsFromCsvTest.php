<?php

namespace Test\Integration;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;
use Src\Adapter\Controller\ImportFairsController;
use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Test\Helpers\Traits\WebTestCase;
use Mockery;

class ImportFairsFromCsvTest extends DatabaseTestCase
{
    use RandomValueGenerator, WebTestCase;

    public function testImportFromCsv()
    {
        $duplicated = $this->randomFairArrayData();
        $duplicated['id'] = 25;
        (new FairRepositorySqlite())->save(FairFactory::oneFromArray($duplicated));

        $validationFake = Mockery::mock(Validation::class)
            ->shouldReceive('validate')
            ->andReturn(true)
            ->shouldReceive('fails')
            ->andReturn(false)
            ->getMock();

        $validatorFake = Mockery::mock(Validator::class)
            ->shouldReceive('make')
            ->andReturn($validationFake)
            ->getMock();

        $response = $this->postWithFile(
            controller: new ImportFairsController($validatorFake),
            path : '/var/www/storage/stubs/example.csv',
            name : 'example.csv',
            type : 'text/csv',
        );

        $expected = [
            "created" => 3,
            "duplicatedIds" => [25],
            "linesWithErrors" => [
                5
            ]
        ];

        $this->assertEquals(
            $expected,
            json_decode($response->body(), true)
        );
    }

    public function testTryImportInvalidFile()
    {
        $response = $this->postWithFile(
            controller: new ImportFairsController(),
            path : '/var/www/storage/stubs/example.csv',
            name : 'example.csv',
            type : 'text/csv',
        );

        $expected =  [
            'message' => 'Validation error',
            'errors' => [
                'csv_file' => 'The Csv file is not valid uploaded file',
            ]
        ];

        $this->assertEquals(
            $expected,
            json_decode($response->body(), true)
        );
    }
}