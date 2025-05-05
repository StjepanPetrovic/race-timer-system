<?php
// src/Controller/FinishLineController.php
namespace App\Controller;

use App\DTO\FinishLineRequest;
use App\Entity\Result;
use App\Message\UpdateLeaderboardMessage;
use App\Repository\RaceRepository;
use App\Repository\RunnerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FinishLineController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly RaceRepository $raceRepository,
        private readonly RunnerRepository $runnerRepository,
        private readonly SerializerInterface $serializer,
        private readonly LoggerInterface $logger,
        private MessageBusInterface $messageBus
    ) {
        $this->logger->info('FinishLineController created');
    }

    #[Route('/api/finish-line', methods: ['POST'])]
    public function recordFinish(Request $request, ): JsonResponse
    {
        $dto = $this->serializer->deserialize($request->getContent(), FinishLineRequest::class, 'json');

        $this->logger->info('Received finish line request =' . $dto->start_number . ' KRAJ');

        // Validate incoming data
        if (!$dto->start_number || !$dto->race_id || !$dto->time) {
            return new JsonResponse(['error' => 'Missing required fields'], 400);
        }

        // Find the race
        $race = $this->raceRepository->find($dto->race_id);
        if (!$race) {
            throw new NotFoundHttpException('Race not found');
        }

        $this->logger->info('Race found' . $race->getId());

        $runner = $this->runnerRepository->findOneBy(['startNumber' => $dto->start_number]);
        if (!$runner) {
            throw new NotFoundHttpException('Runner not found');
        }

        $this->logger->info('Runner found' . $runner->getId());

        // Create new result
        $result = new Result();
        $result->setRace($race);
        $result->setRunner($runner);
        $result->setTime(new \DateTimeImmutable($dto->time->format('Y-m-d H:i:s')));

        $this->entityManager->persist($result);
        $this->entityManager->flush();

        $this->logger->info('Finished finish line request', ['result' => $result]);

        $this->messageBus->dispatch(new UpdateLeaderboardMessage(
            $result->getRace()->getId(),
            $result->getRunner()->getId(),
            $result->getTime()
        ));

        return new JsonResponse(['id' => $result->getId()], 201);
    }
}