<?php

namespace App\Controller\Api;

use App\DTO\CandidateName;
use App\DTO\CandidatePlace;
use App\Entity\Candidate;
use App\Repository\CandidateRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class CandidateController extends AbstractController
{
    #[Route('/api/candidate/{id}', methods: ['GET'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД кандидата',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\Response(
        response: 200,
        description: 'кандидат с портфолио и навыками',
        content: new OA\JsonContent(
            ref: new Model(
                type: Candidate::class,
                groups: ['full'],
            ),
        ),
    )]
    #[OA\Response(
        response: 404,
        description: 'кандидат не существует',
    )]
    public function get(Candidate $candidate, SerializerInterface $serializer): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())->withGroups(['full'])->toArray();
        return $this->json($serializer->normalize($candidate, null, $context));
    }

    #[Route('/api/candidate/name/{id}', methods: ['PATCH'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД кандидата',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\RequestBody(
        description: 'Обновить имя кандидата',
        content: new Model(
            type: CandidateName::class,
        ),
    )]
    #[OA\Response(
        response: 204,
        description: 'имя кандидата успешно изменено',
    )]
    #[OA\Response(
        response: 422,
        description: 'в параметрах запроса нет соответствия  DTO\CandidateName',
    )]
    public function putName(Candidate $candidate, #[MapRequestPayload] CandidateName $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate->setName($dto->getName());
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/candidate/place/{id}', methods: ['PATCH'])]
    #[OA\Parameter(
        name: 'id',
        description: 'ИД кандидата',
        in: 'path',
        allowEmptyValue: false,
        schema: new OA\Schema(type: 'string',),
    )]
    #[OA\RequestBody(
        description: 'Обновить местоположение кандидата',
        content: new Model(
            type: CandidatePlace::class,
        ),
    )]
    #[OA\Response(
        response: 204,
        description: 'местоположение кандидата успешно изменено',
    )]
    #[OA\Response(
        response: 422,
        description: 'в параметрах запроса нет соответствия  DTO\CandidatePlace',
    )]    public function patchPlace(Candidate $candidate, #[MapRequestPayload] CandidatePlace $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate->setPlace($dto->getPlace());
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
