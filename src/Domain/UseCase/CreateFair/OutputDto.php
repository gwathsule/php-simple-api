<?php

namespace Src\Domain\UseCase\CreateFair;


class OutputDto
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
        public readonly ?string $numero,
        public readonly string $bairro,
        public readonly ?string $referencia
    ) {}

    public static function buildFromArray(array $attributes) : self
    {
        return new self(
            id: $attributes['id'],
            long: $attributes['long'],
            lat: $attributes['lat'],
            setcens: $attributes['setcens'],
            areap: $attributes['areap'],
            coddist: $attributes['coddist'],
            distrito: $attributes['distrito'],
            codsubpref: $attributes['codsubpref'],
            subprefe: $attributes['subprefe'],
            regiao5: $attributes['regiao5'],
            regiao8: $attributes['regiao8'],
            nome_feira: $attributes['nome_feira'],
            registro: $attributes['registro'],
            logradouro: $attributes['logradouro'],
            numero: $attributes['numero'],
            bairro: $attributes['bairro'],
            referencia: $attributes['referencia'],
        );
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