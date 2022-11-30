<?php

namespace Src\Domain\UseCase\DeleteFair;

use Src\Domain\Contracts\Logger;
use Src\Domain\Exception\ItemNotFoundException;
use Src\Domain\Repository\FairRepository;

class DeleteFair
{
    public function __construct(private FairRepository $fairRepository, private Logger $logger)
    {
    }

    public function execute($id) : bool
    {
        $fair = $this->fairRepository->find($id);
        if(is_null($fair)) {
            throw new ItemNotFoundException();
        }
        $this->fairRepository->delete($fair->get('id'));
        $this->logger->logInfo('Deleted Fair', $fair->toArray());
        return true;
    }
}