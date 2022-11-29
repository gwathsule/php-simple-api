<?php

namespace Src\Domain\Entity\Fair;

class Fair
{
    public function __construct(
        private int $id,
        private string $long,
        private string $lat,
        private string $setcens,
        private string $areap,
        private int $coddist,
        private string $distrito,
        private int $codsubpref,
        private string $subprefe,
        private string $regiao5,
        private string $regiao8,
        private string $nome_feira,
        private string $registro,
        private string $logradouro,
        private ?string $numero,
        private string $bairro,
        private ?string $referencia
    ) {
    }

    public function get($attribute) : mixed
    {
        return $this->$attribute;
    }

    public function set($attribute, $value) : void
    {
        $this->$attribute = $value;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'long' => $this->long,
            'lat' => $this->lat,
            'setcens' => $this->setcens,
            'areap' => $this->areap,
            'coddist' => $this->coddist,
            'distrito' => $this->distrito,
            'codsubpref' => $this->codsubpref,
            'subprefe' => $this->subprefe,
            'regiao5' => $this->regiao5,
            'regiao8' => $this->regiao8,
            'nome_feira' => $this->nome_feira,
            'registro' => $this->registro,
            'logradouro' => $this->logradouro,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'referencia' => $this->referencia,
        ];
    }
}