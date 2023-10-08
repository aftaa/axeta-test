<?php

namespace App\Controller\Api;

use App\DTO\NewSkill;
use App\DTO\SkillExperience;
use App\DTO\SkillName;
use App\Entity\Skill;
use App\Repository\CandidateRepository;
use App\Repository\SkillRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class SkillController extends AbstractController
{
    #[Route('/api/skill', methods: ['POST'])]
    #[OA\RequestBody(
        description: 'Создать навык',
        content: new Model(
            type: NewSkill::class,
        ),
    )]
    #[OA\Response(
        response: 201,
        description: 'навык успешно создан',
    )]
    #[OA\Response(
        response: 422,
        description: 'невалидное тело запроса',
    )]
    #[OA\Response(
        response: 404,
        description: 'кандидат не существует',
    )]
    public function post(#[MapRequestPayload] NewSkill $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate = $repository->find($dto->getCandidateId());
        if (!$candidate) {
            throw $this->createNotFoundException();
        }
        $skill = new Skill();
        $skill->setName($dto->getName())->setExperience(0);
        $candidate->addSkill($skill);
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_CREATED);
    }


    #[Route('/api/skill/{id}', methods: ['DELETE'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД навыка',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\RequestBody(
        description: 'Удалить навык',
    )]
    #[OA\Response(
        response: 204,
        description: 'навык успешно удален',
    )]
    #[OA\Response(
        response: 404,
        description: 'навык не найден',
    )]
    public function delete(Skill $skill, SkillRepository $repository): JsonResponse
    {
        $repository->remove($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/skill/name/{id}', methods: ['PATCH'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД навыка',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\RequestBody(
        description: 'Обновить название навыка',
        content: new Model(
            type: SkillName::class,
        ),
    )]
    #[OA\Response(
        response: 204,
        description: 'название навыка успешно изменено',
    )]
    #[OA\Response(
        response: 422,
        description: 'невалидное тело запроса',
    )]
    public function patchName(Skill $skill, #[MapRequestPayload] SkillName $dto, SkillRepository $repository): JsonResponse
    {
        $skill->setName($dto->getName());
        $repository->save($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/skill/experience/{id}', methods: ['PATCH'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД навыка',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\RequestBody(
        description: 'Обновить количество лет навыка',
        content: new Model(
            type: SkillExperience::class,
        ),
    )]
    #[OA\Response(
        response: 204,
        description: 'кол-во лет навыка успешно изменено',
    )]
    #[OA\Response(
        response: 422,
        description: 'невалидное тело запроса',
    )]
    #[OA\Response(
        response: 404,
        description: 'скилл не существует',
    )]
    public function patchExperience(Skill $skill, #[MapRequestPayload] SkillExperience $dto, SkillRepository $repository): JsonResponse
    {
        $skill->setExperience($dto->getExperience());
        $repository->save($skill, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
