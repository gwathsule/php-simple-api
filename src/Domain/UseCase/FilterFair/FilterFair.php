<?php

namespace Src\Domain\UseCase\FilterFair;

use Src\Domain\Repository\FairRepository;

class FilterFair
{
    public function __construct(private FairRepository $fairRepository)
    {
    }

    public function execute(InputDto $inputData) : array
    {
        $fairs = $this->fairRepository->filterBy($inputData->toArray());
        $response = [];
        foreach ($fairs as $fair) {
            array_push($response, $fair->toArray());
        }
        return $response;
    }
}