<?php

namespace Src\Domain\UseCase\CreateFair;

use Src\Domain\Repository\FairRepository;

class CreateFair
{
    public function __construct(FairRepository $fairRepository)
    {
    }

    //cria a lógica de negócio para importar várias Feiras em lote
    public function execute(InputDto $data) : OutputDto
    {
        throw new \Exception("not implemented");
        //verifica se não há nenhum registro de ID duplicado, caso o contrário não deixa seguir
    }
}