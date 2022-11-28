<?php

namespace Domain\UseCase;

use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Exception\DuplicatedRegisterException;
use Src\Domain\UseCase\CreateFair\InputInputDto;
use Test\DatabaseTestCase;
use Src\Domain\UseCase\CreateFair\CreateFair as UseCase;
use Test\Helpers\Traits\RandomValueGenerator;

class CreateFairTest extends DatabaseTestCase
{
    use RandomValueGenerator;

    public function testCreateFairWithSuccess()
    {
        $data = $this->randomFairArrayData();
        $repository = new FairRepositorySqlite();
        $useCase = new UseCase($repository);
        $inputData = InputInputDto::buildFromArray($data);
        $output = $useCase->execute($inputData);
        $this->assertEquals($data, $output->toArray());
    }

    public function testTryCreateDuplicatedFair()
    {
        $repository = new FairRepositorySqlite();

        $dataDuplicated = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($dataDuplicated);
        $repository->save($fair);

        $dataDuplicated = $this->randomFairArrayData();
        $dataDuplicated['id'] = $fair->get('id');

        $useCase = new UseCase($repository);
        $inputData = InputInputDto::buildFromArray($dataDuplicated);

        $this->expectException(DuplicatedRegisterException::class);
        $useCase->execute($inputData);
    }
}