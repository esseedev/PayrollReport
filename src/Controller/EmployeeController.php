<?php
declare(strict_types=1);

namespace App\Controller;

use App\Command\CreateEmployeeCommand;
use App\Repository\DepartmentRepository;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class EmployeeController
{
    public function __construct
    (
        private MessageBusInterface $commandBus,
        private DepartmentRepository $departmentRepository,
    ) {}

    #[Route('/employee', name: 'create_employee', methods: ['POST'])]
    public function createEmployee(
        #[MapRequestPayload] CreateEmployeeCommand $command
    ): JsonResponse {
        if ($this->departmentRepository->find($command->departmentId)) {
            return new JsonResponse(['message' => 'Department not found'],
                Response::HTTP_NOT_FOUND);
        }

        try {
            $command = new CreateEmployeeCommand(
                name: $command->name,
                lastName: $command->lastName,
                departmentId: $command->departmentId,
                startDate: $command->startDate,
                wageBase: $command->wageBase,
                fixedYearlySupplementAmount: $command->fixedYearlySupplementAmount,
            );

            $this->commandBus->dispatch($command);
            return new JsonResponse(
                ['message' => 'Employee created successfully'],
                Response::HTTP_CREATED
            );
        } catch (Exception $exception) {
            return new JsonResponse(
                [
                    'message' => sprintf(
                        'Error creating employee: %s',
                        $exception->getMessage()
                    )
                ], Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}