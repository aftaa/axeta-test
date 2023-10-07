<?php

namespace App\DTO;

readonly class SkillExperience
{
    public function __construct(
        private string $experience,
    )
    {
    }

    public function getExperience(): string
    {
        return $this->experience;
    }
}
