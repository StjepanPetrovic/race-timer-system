<?php

namespace App\Controller;

use App\Entity\Result;
use App\Service\ResultService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/result/add', name: 'add_result', methods: ['POST'])]
class ResultController extends AbstractController
{
    public function __construct(
        private ResultService $resultService
    ) {
    }

    public function addResult(Result $result): Response
    {
        $this->resultService->saveResult($result);

        return $this->json(['status' => 'ok']);
    }
}