<?php

namespace Src\Domain\UseCase\FilterFair;

class InputDto
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?string $distrito = null,
        public readonly ?string $regiao5 = null,
        public readonly ?string $nome_feira = null,
        public readonly ?string $bairro = null
    ) {
    }

    public static function buildFromArray(array $attributes) : self
    {
        return new self(
            id: $attributes['id'] ?? null,
            distrito: $attributes['distrito'] ?? null,
            regiao5: $attributes['regiao5'] ?? null,
            nome_feira: $attributes['nome_feira'] ?? null,
            bairro: $attributes['bairro'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'distrito' => $this->distrito,
            'regiao5' => $this->regiao5,
            'nome_feira' => $this->nome_feira,
            'bairro' => $this->bairro,
        ];
    }
}