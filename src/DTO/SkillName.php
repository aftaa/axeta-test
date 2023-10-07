<?php

namespace App\DTO;

readonly class SkillName
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
