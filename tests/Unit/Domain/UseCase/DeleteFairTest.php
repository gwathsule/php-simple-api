<?php

namespace Domain\UseCase;

use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Exception\ItemNotFoundException;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;
use Src\Domain\UseCase\DeleteFair\DeleteFair as UseCase;

class DeleteFairTest extends DatabaseTestCase
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

    public function testDelete()
    {
        $dataDuplicated = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($dataDuplicated);
        $this->repository->save($fair);

        $this->useCase->execute($fair->get('id'));
        $fairOnDatabase = $this->repository->find($fair->get('id'));

        $this->assertNull($fairOnDatabase);
    }

    public function testTryDeleteNonexistent()
    {
        $data = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($data);
        $this->expectException(ItemNotFoundException::class);
        $this->useCase->execute($fair->get('id'));
    }
}