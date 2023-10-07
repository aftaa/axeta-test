<?php

namespace App\DTO;

readonly class NewSkill
{
    public function __construct(
        private int $candidateId,
        private string $name,
    )
    {
    }

    public function getCandidateId(): int
    {
        return $this->candidateId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
