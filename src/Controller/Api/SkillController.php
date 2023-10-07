<?php

namespace App\Controller\Api;

use App\DTO\NewSkill;
use App\Entity\Candidate;
use App\Entity\Skill;
use App\Repository\CandidateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/api/skill', methods: ['POST'])]
    public function post(#[MapRequestPayload] NewSkill $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate = $repository->find($dto->getCandidateId());
        $skill = new Skill();
        $skill->setName($dto->getName())->setExperience(0);
        $candidate->addSkill($skill);
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_CREATED);
    }
}
