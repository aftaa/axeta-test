<?php

namespace App\Entity;

use App\Repository\CandidateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CandidateRepository::class)]
class Candidate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('full')]
    #[OA\Property(description: 'ИД кандидата')]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups('full')]
    #[OA\Property(description: 'Имя')]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    #[OA\Property(description: 'Местоположение')]
    #[Groups('full')]
    private ?string $place = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: 'Юзерпик')]
    #[Groups('full')]
    private ?string $photo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups('full')]
    #[OA\Property(description: 'Местоположение')]

    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: 'Режим работы')]
    #[Groups('full')]
    private ?string $availability = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: 'Рабочее окружение')]
    #[Groups('full')]
    private ?string $environment = null;

    #[ORM\Column(type: Types::TEXT)]
    #[OA\Property(description: 'Самое удивительно')]
    #[Groups('full')]
    private ?string $amaizing = null;

    #[ORM\Column(length: 255)]
    #[OA\Property(description: 'Ожидание от работы')]
    #[Groups('full')]
    private ?string $expectation = null;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Portfolio::class, cascade: ['persist'])]
    #[OA\Property(description: 'Коллекция портфолио')]
    #[Groups('full')]
    private Collection $portfolios;

    #[ORM\OneToMany(mappedBy: 'candidate', targetEntity: Skill::class, cascade: ['persist'])]
    #[OA\Property(description: 'Навыки')]
    #[Groups('full')]
    private Collection $skills;

    #[ORM\Column(length: 50)]
    #[Groups('full')]
    private ?string $lang = null;

    public function __construct()
    {
        $this->portfolios = new ArrayCollection();
        $this->skills = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getAvailability(): ?string
    {
        return $this->availability;
    }

    public function setAvailability(string $availability): static
    {
        $this->availability = $availability;

        return $this;
    }

    public function getEnvironment(): ?string
    {
        return $this->environment;
    }

    public function setEnvironment(string $environment): static
    {
        $this->environment = $environment;

        return $this;
    }

    public function getAmaizing(): ?string
    {
        return $this->amaizing;
    }

    public function setAmaizing(string $amaizing): static
    {
        $this->amaizing = $amaizing;

        return $this;
    }

    public function getExpectation(): ?string
    {
        return $this->expectation;
    }

    public function setExpectation(string $expectation): static
    {
        $this->expectation = $expectation;

        return $this;
    }

    /**
     * @return Collection<int, Portfolio>
     */
    public function getPortfolios(): Collection
    {
        return $this->portfolios;
    }

    public function addPortfolio(Portfolio $portfolio): static
    {
        if (!$this->portfolios->contains($portfolio)) {
            $this->portfolios->add($portfolio);
            $portfolio->setCandidate($this);
        }

        return $this;
    }

    public function removePortfolio(Portfolio $portfolio): static
    {
        if ($this->portfolios->removeElement($portfolio)) {
            // set the owning side to null (unless already changed)
            if ($portfolio->getCandidate() === $this) {
                $portfolio->setCandidate(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Skill>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skill $skill): static
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setCandidate($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): static
    {
        if ($this->skills->removeElement($skill)) {
            // set the owning side to null (unless already changed)
            if ($skill->getCandidate() === $this) {
                $skill->setCandidate(null);
            }
        }

        return $this;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    public function setLang(string $lang): static
    {
        $this->lang = $lang;

        return $this;
    }
}
