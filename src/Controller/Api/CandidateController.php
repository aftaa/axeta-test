<?php

namespace App\Controller\Api;

use App\Entity\Candidate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\SerializerInterface;

class CandidateController extends AbstractController
{
    private array $context;
    public function __construct(
        private readonly SerializerInterface $serializer,
    )
    {
        $this->context = (new ObjectNormalizerContextBuilder())
//            ->withEnableMaxDepth(true)
            ->withGroups(['api'])
            ->toArray();
    }

    #[Route('/api/candidate/{id}', methods: ['GET'])]
    public function index(Candidate $candidate): JsonResponse
    {
        return $this->json($this->serializer->normalize($candidate, null, $this->context));
    }
}
