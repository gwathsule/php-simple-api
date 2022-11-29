<?php

namespace Src\Domain\Entity\Fair;

class FairFactory
{
    public static function oneFromArray($array): Fair
    {
        return new Fair(
            id: $array['id'],
            long: $array['long'],
            lat: $array['lat'],
            setcens: $array['setcens'],
            areap: $array['areap'],
            coddist: $array['coddist'],
            distrito: $array['distrito'],
            codsubpref: $array['codsubpref'],
            subprefe: $array['subprefe'],
            regiao5: $array['regiao5'],
            regiao8: $array['regiao8'],
            nome_feira: $array['nome_feira'],
            registro: $array['registro'],
            logradouro: $array['logradouro'],
            numero: $array['numero'] ?? null,
            bairro: $array['bairro'],
            referencia: $array['referencia'] ?? null
        );
    }
}