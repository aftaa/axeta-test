<?php

namespace App\Entity;

use App\Repository\SkillRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SkillRepository::class)]
class Skill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[OA\Property(description: 'ИД навыка')]
    #[Groups('full')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'skills')]
    #[ORM\JoinColumn(nullable: false)]
    #[OA\Property(description: 'кандидат')]
    private ?Candidate $candidate = null;

    #[ORM\Column(length: 50)]
    #[OA\Property(description: 'название навыка')]
    #[Groups('full')]
    private ?string $name = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 1)]
    #[OA\Property(description: 'опыт в годах')]
    #[Groups('full')]
    private ?string $experience = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCandidate(): ?Candidate
    {
        return $this->candidate;
    }

    public function setCandidate(?Candidate $candidate): static
    {
        $this->candidate = $candidate;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): static
    {
        $this->experience = $experience;

        return $this;
    }
}
