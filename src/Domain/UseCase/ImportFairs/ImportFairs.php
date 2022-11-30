<?php

namespace Src\Domain\UseCase\ImportFairs;

use Src\Domain\Entity\Fair\Fair;
use Src\Domain\Repository\FairRepository;
use Throwable;

class ImportFairs
{
    public function __construct(private FairRepository $fairRepository)
    {
    }

    public function execute($path) : OutputDto
    {
        $fairs = array_map('str_getcsv', file($path));

        $created = 0;
        $duplicatedIds = [];
        $linesWithErrors = [];

        foreach ($fairs as $line => $fairData) {
            if ($line == 0) continue;
            try {
                $fair = $this->buildFair($fairData);
                if($this->isDuplicated($fair->get('id'))) {
                    array_push($duplicatedIds, $fair->get('id'));
                } else {
                    $this->fairRepository->save($fair);
                    $created++;
                }
            } catch (Throwable) {
                array_push($linesWithErrors, $line);
            }
        }

        return new OutputDto(
            created: $created,
            duplicatedIds: $duplicatedIds,
            linesWithErrors: $linesWithErrors
        );
    }

    private function isDuplicated(int $id): bool
    {
        return $this->fairRepository->find($id) != null;
    }

    private function buildFair($data): Fair
    {
        return new Fair(
            id: $data[0],
            long: $data[1],
            lat: $data[2],
            setcens: $data[3],
            areap: $data[4],
            coddist: $data[5],
            distrito: $data[6],
            codsubpref: $data[7],
            subprefe: $data[8],
            regiao5: $data[9],
            regiao8: $data[10],
            nome_feira: $data[11],
            registro: $data[12],
            logradouro: $data[13],
            numero: $data[14],
            bairro: $data[15],
            referencia: $data[16]
        );
    }
}