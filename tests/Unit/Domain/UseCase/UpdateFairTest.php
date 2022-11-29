<?php

namespace Domain\UseCase;

use Src\Adapter\Repository\Sqlite\FairRepositorySqlite;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\UseCase\UpdateFair\UpdateFair as UseCase;
use Test\DatabaseTestCase;
use Test\Helpers\Traits\RandomValueGenerator;

class UpdateFairTest extends DatabaseTestCase
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

    public function testUpdateFair()
    {
        $data = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($data);
        $this->repository->save($fair);

        $dataToUpdate['nome_feira'] = $data['nome_feira'] . ' updated';
        $dataToUpdate['logradouro'] = $data['logradouro'] . ' updated';
        $dataToUpdate['bairro'] = $data['bairro'] . ' updated';
        $dataToUpdate['numero'] = null;
        $dataToUpdate['codsubpref'] = $data['codsubpref'] + 10;

        $fairUpdated = $this->useCase->execute($dataToUpdate, $fair->get('id'));

        $expectedUpdate = array_merge($data, $dataToUpdate);
        $this->assertEquals($expectedUpdate, $fairUpdated->toArray());
    }

    public function testUpdateNothing()
    {
        $data = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($data);
        $this->repository->save($fair);

        $fairUpdated = $this->useCase->execute([], $fair->get('id'));
        $this->assertEquals($data, $fairUpdated->toArray());
    }

    public function testTryUpdateNonexistent()
    {
        $data = $this->randomFairArrayData();
        $fair = FairFactory::oneFromArray($data);
        $this->expectException(ItemNotFoundException::class);
        $this->useCase->execute([], $fair->get('id'));
    }
}