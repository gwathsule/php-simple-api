<?php

namespace Test\Helpers\Traits;

trait RandomValueGenerator
{
    private function randomInt(int $min, int $max) : int
    {
        return random_int($min, $max);
    }

    private function randomCoordinates() : string
    {
        return (string) random_int(-99999999, -11111111);
    }

    private function randomName(): string
    {
        $names = [
            'VILA FORMOSA',
            'VILA PRUDENTE',
            'BRAS',
            'PENHA',
            'CIDADE LIDER',
            'PEDREIRA',
            'FREGUESIA DO O',
            'LAJEADO',
            'PERDIZES',
            'PENHA',
            'ARICANDUVA-FORMOSA-CARRAO',
        ];
        $key = array_rand($names);
        return $names[$key];
    }

    private function randomRegion(): string
    {
        $regions = [
            'Leste',
            'Sul',
            'Norte',
            'Oeste',
        ];
        $key = array_rand($regions);
        return $regions[$key];
    }

    private function randomRegister(): string
    {
        return $this->randomInt(1000, 9999) . '-' . $this->randomInt(0, 9);
    }

    private function randomAddressNumber() : string
    {
        $values = [
            $this->randomInt(1, 999) . '.000000',
            'S/N',
            '',
        ];
        $key = array_rand($values);
        return $values[$key];
    }

    private function randomFairArrayData() : array
    {
        return [
            'id' => $this->randomInt(1, 999),
            'long' => $this->randomCoordinates(),
            'lat' => $this->randomCoordinates(),
            'setcens' => (string) $this->randomInt(10000, 999999),
            'areap' => (string) $this->randomInt(10000, 999999),
            'coddist' => $this->randomInt(1, 99),
            'distrito' => $this->randomName(),
            'codsubpref' => $this->randomInt(1, 99),
            'subprefe' => $this->randomName(),
            'regiao5' => $this->randomRegion(),
            'regiao8' => $this->randomRegion(),
            'nome_feira' => $this->randomName(),
            'registro' => $this->randomRegister(),
            'logradouro' => 'RUA ' . $this->randomName(),
            'numero' => $this->randomAddressNumber(),
            'bairro' => $this->randomName(),
            'referencia' => $this->randomName(),
        ];
    }
}