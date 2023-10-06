<?php

namespace App\Controller\Api;

use App\DTO\CandidateName;
use App\DTO\CandidatePlace;
use App\Entity\Candidate;
use App\Repository\CandidateRepository;
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
    public function get(Candidate $candidate, SerializerInterface $serializer): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['api'])
            ->toArray();
        return $this->json($serializer->normalize($candidate, null, $context));
    }

    #[Route('/api/candidate/{id}', methods: ['PUT'])]
    public function putName(Candidate $candidate, #[MapRequestPayload] CandidateName $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate->setName($dto->getName());
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('/api/candidate/{id}', methods: ['PATCH'])]
    public function patchPlace(Candidate $candidate, #[MapRequestPayload] CandidatePlace $dto, CandidateRepository $repository): JsonResponse
    {
        $candidate->setPlace($dto->getPlace());
        $repository->save($candidate, true);
        return $this->json(null, Response::HTTP_NO_CONTENT);
    }
}
