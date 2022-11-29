<?php

namespace Src\Domain\UseCase\UpdateFair;

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
            long: $attributes['long'] ?? null,
            lat: $attributes['lat'] ?? null,
            setcens: $attributes['setcens'] ?? null,
            areap: $attributes['areap'] ?? null,
            coddist: $attributes['coddist'] ?? null,
            distrito: $attributes['distrito'] ?? null,
            codsubpref: $attributes['codsubpref'] ?? null,
            subprefe: $attributes['subprefe'] ?? null,
            regiao5: $attributes['regiao5'] ?? null,
            regiao8: $attributes['regiao8'] ?? null,
            nome_feira: $attributes['nome_feira'] ?? null,
            registro: $attributes['registro'] ?? null,
            logradouro: $attributes['logradouro'] ?? null,
            numero: $attributes['numero'] ?? null,
            bairro: $attributes['bairro'] ?? null,
            referencia: $attributes['referencia'] ?? null,
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