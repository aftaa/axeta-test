<?php

namespace App\DTO;

readonly class CandidatePlace
{
    public function __construct(
        private string $place,
    )
    {
    }

    public function getPlace(): string
    {
        return $this->place;
    }
}
