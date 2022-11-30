<?php

namespace Src\Domain\UseCase\CreateFair;


class OutputDto extends InputInputDto
{
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
}