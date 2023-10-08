<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SkillName
{
    public function __construct(
        #[Assert\NotBlank()]
        #[OA\Property(description: 'название навыка')]
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
