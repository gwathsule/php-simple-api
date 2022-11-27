<?php

namespace Src\Domain\Repository;

use Src\Domain\Entity\Fair\Fair;

interface FairRepository
{
    public function save(Fair $fair): bool;

    public function update(Fair $fair): bool;

    public function delete(int $id): bool;

    public function find(int $id): ?Fair;

    public function getBy(string $attribute, string $value): array;
}