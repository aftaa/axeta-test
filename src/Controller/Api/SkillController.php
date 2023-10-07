<?php

namespace App\Controller\Api;

use App\DTO\NewSkill;
use App\DTO\SkillExperience;
use App\DTO\SkillName;
use App\Entity\Candidate;
use App\Entity\Skill;
use App\Repository\CandidateRepository;
use App\Repository\SkillRepository;
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

    #[Route('/api/skill/{id}', methods: ['DELETE'])]
    public function delete(Skill $skill, SkillRepository $repository): JsonResponse
    {
        $repository->remove($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/skill/name/{id}', methods: ['PATCH'])]
    public function patchName(Skill $skill, #[MapRequestPayload] SkillName $dto, SkillRepository $repository): JsonResponse
    {
        $skill->setName($dto->getName());
        $repository->save($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/skill/experience/{id}', methods: ['PATCH'])]
    public function patchExperience(Skill $skill, #[MapRequestPayload] SkillExperience $dto, SkillRepository $repository): JsonResponse
    {
        $skill->setExperience($dto->getExperience());
        $repository->save($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
