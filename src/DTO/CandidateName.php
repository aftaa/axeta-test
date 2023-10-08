<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CandidateName
{
    public function __construct(
        #[Assert\NotBlank()]
        #[OA\Property(description: 'имя кандидата')]
        private string $name,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
