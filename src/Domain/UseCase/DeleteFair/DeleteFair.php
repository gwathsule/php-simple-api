<?php

namespace Src\Domain\UseCase\DeleteFair;

use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\Repository\FairRepository;

class DeleteFair
{
    public function __construct(private FairRepository $fairRepository)
    {
    }

    public function execute($id) : bool
    {
        $fair = $this->fairRepository->find($id);
        if(is_null($fair))
        {
            throw new ItemNotFoundException();
        }

        return $this->fairRepository->delete($fair->get('id'));
    }
}