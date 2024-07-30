<?php
declare(strict_types=1);

namespace App\Controller;

use App\Command\CreateDepartmentCommand;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class DepartmentController 
{
    public function __construct
    (
        private MessageBusInterface $commandBus,
    ) { }
    
    #[Route('/department', name: 'department', methods: ['POST'])]
    public function createDepartment(#[MapRequestPayload] CreateDepartmentCommand $command): JsonResponse {
        try {
            $this->commandBus->dispatch($command);
            return new JsonResponse(['message' => 'Department created successfully'], Response::HTTP_CREATED);
        } catch (Exception $exception) {
            return new JsonResponse(['message' => 'Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}