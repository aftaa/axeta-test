<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SkillExperience
{
    public function __construct(
        #[Assert\NotBlank()]
        #[OA\Property(description: 'кол-во лет опыта', type: 'integer')]
        private string $experience,
    )
    {
    }

    public function getExperience(): string
    {
        return $this->experience;
    }
}
