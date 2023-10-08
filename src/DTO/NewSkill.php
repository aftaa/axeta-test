<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class NewSkill
{
    public function __construct(
        #[Assert\NotBlank()]
        #[OA\Property(description: 'ИД кандидата')]
        private int $candidateId,

        #[Assert\NotBlank()]
        #[OA\Property(description: 'Имя кандидата')]
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
