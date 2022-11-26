<?php

namespace Src\Domain\UseCase\CreateFair;

class InputDto
{
    public function __construct(
         public readonly int $id,
         public readonly string $long,
         public readonly string $lat,
         public readonly string $setcens,
         public readonly string $areap,
         public readonly int $coddist,
         public readonly string $distrito,
         public readonly int $codsubpref,
         public readonly string $subprefe,
         public readonly string $regiao5,
         public readonly string $regiao8,
         public readonly string $nome_feira,
         public readonly string $registro,
         public readonly string $logradouro,
         public readonly string $numero,
         public readonly string $bairro,
         public readonly string $referencia
    ) {}
}