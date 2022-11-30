<?php

namespace Src\Domain\UseCase\ImportFairs;

class OutputDto
{
    public function __construct(
        public readonly int $created,
        public readonly array $duplicatedIds,
        public readonly array $linesWithErrors
    ) {
    }

    public function toArray(): array
    {
        return [
            'created' => $this->created,
            'duplicatedIds' => $this->duplicatedIds,
            'linesWithErrors' => $this->linesWithErrors,
        ];
    }
}