<?php

namespace Src\Domain\UseCase\UpdateFair;

use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\Repository\FairRepository;

class UpdateFair
{
    public function __construct(private FairRepository $fairRepository)
    {
    }

    public function execute(array $dataToUpdate, int $id) : OutputDto
    {
        $fair = $this->fairRepository->find($id);

        if(is_null($fair)) {
            throw new ItemNotFoundException();
        }

        if($dataToUpdate === []) {
            return OutputDto::buildFromArray($fair->toArray());
        }
        unset($dataToUpdate['id']);

        $fairUpdated = $this->fairRepository->update($dataToUpdate, $id);

        return OutputDto::buildFromArray($fairUpdated->toArray());
    }
}