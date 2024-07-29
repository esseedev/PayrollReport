<?php

namespace App\Controller;

use App\Command\CreateEmployeeCommand;
use App\Entity\Department;
use App\Query\GetCompanyPayrollReportQuery;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class EmployeeController extends AbstractController
{
    public function __construct
    (
        private MessageBusInterface $commandBus,
        private EntityManagerInterface $entityManager
    ) { }
    
    #[Route('/employee', name: 'create_employee', methods: ['POST'])]
    public function createEmployee(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $department = $this->entityManager->getRepository(Department::class)->find($data['id']);
        
        if (!$department) {
            return new JsonResponse(['message' => 'Department not found'], Response::HTTP_NOT_FOUND);
        }
        
        $command = new CreateEmployeeCommand(
            name: $data['name'],
            lastName: $data['lastName'],
            department: $department,
            startDate: new DateTimeImmutable($data['startDate']),
            wageBase: $data['wageBase'],
            fixedYearlySupplementAmount: $data['fixedYearlySupplementAmount'],
        );
        
        $this->commandBus->dispatch($command);
        
        return new JsonResponse(['message' => 'Employee created successfully'], Response::HTTP_CREATED);
    }
}