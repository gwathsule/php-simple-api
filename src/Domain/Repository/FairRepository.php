<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\Fair\Fair;

interface FairRepository
{
    public function save(Fair $fair): void;

    public function update(array $attributes, int $id): Fair;

    public function delete(int $id): bool;

    public function find(int $id): ?Fair;

    public function filterBy(array $filters) : array;
}