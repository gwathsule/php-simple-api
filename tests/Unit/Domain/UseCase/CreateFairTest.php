<?php

namespace Domain\UseCase;

use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Exception\DuplicatedRegisterException;
use Src\Domain\UseCase\CreateFair\InputDto;
use Test\DatabaseTestCase;
use Src\Domain\UseCase\CreateFair\CreateFair as UseCase;
use Test\Helpers\Traits\RandomValueGenerator;

class CreateFairTest extends DatabaseTestCase
{
    use RandomValueGenerator;

    private FairRepositorySqlite $repository;
    private UseCase $useCase;

    protected function setUp(): void
    {
        $this->repository = new FairRepositorySqlite();
        $this->useCase = new UseCase($this->repository);
        parent::setUp();
    }

    public function testCreateFairWithSuccess()
    {
        $data = $this->randomFairArrayData();
        $inputData = InputDto::buildFromArray($data);
        $output = $this->useCase->execute($inputData);
        $this->assertEquals($data, $output->toArray());
    }

    public function testTryCreateDuplicatedFair()
    {
        $dataDuplicated = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($dataDuplicated);
        $this->repository->save($fair);

        $dataDuplicated = $this->randomFairArrayData();
        $dataDuplicated['id'] = $fair->get('id');
        $inputData = InputDto::buildFromArray($dataDuplicated);

        $this->expectException(DuplicatedRegisterException::class);
        $this->useCase->execute($inputData);
    }
}