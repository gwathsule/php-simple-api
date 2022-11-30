<?php

namespace Src\Domain\UseCase\CreateFair;

use Src\Domain\Contracts\Logger;
use Src\Domain\Entity\Fair\FairFactory;
use Src\Domain\Exception\DuplicatedRegisterException;
use Src\Domain\Repository\FairRepository;

class CreateFair
{
    public function __construct(private FairRepository $fairRepository, private Logger $logger)
    {
    }

    /**
     * @throws DuplicatedRegisterException
     */
    public function execute(InputInputDto $data) : OutputDto
    {
        $fair = $this->fairRepository->find($data->id);
        if(! is_null($fair)) {
            throw new DuplicatedRegisterException($data->id);
        }
        $newFair = FairFactory::oneFromArray($data->toArray());
        $this->fairRepository->save($newFair);
        $this->logger->logInfo('Created new Fair', $data->toArray());
        return OutputDto::buildFromArray($data->toArray());
    }
}