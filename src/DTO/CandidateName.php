<?php

namespace App\DTO;

readonly class CandidateName
{
    public function __construct(
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
