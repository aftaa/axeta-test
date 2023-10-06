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
    #[Route('/api/candidate/{id}', methods: ['GET'])]
    public function index(Candidate $candidate, SerializerInterface $serializer): JsonResponse
    {
        $context = (new ObjectNormalizerContextBuilder())
            ->withGroups(['api'])
            ->toArray();
        return $this->json($serializer->normalize($candidate, null, $context));
    }
}
