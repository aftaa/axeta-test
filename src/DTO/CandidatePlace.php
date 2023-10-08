<?php

namespace App\DTO;

use OpenApi\Attributes as OA;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CandidatePlace
{
    public function __construct(
        #[Assert\NotBlank()]
        #[OA\Property(description: 'местоположение кандидата')]
        private string $place,
    )
    {
    }

    public function getPlace(): string
    {
        return $this->place;
    }
}
