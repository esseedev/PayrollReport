<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Department;
use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;

#[AsMessageHandler]
class CreateEmployeeCommandHandler
{
    public function __construct
    (
        private EntityManagerInterface $entityManager,
        private EmployeeRepository $employeeRepository,
    )
    { }
    
    public function __invoke(CreateEmployeeCommand $command) {
        $department = $this->entityManager->getRepository(Department::class)->find($command->departmentId);
        if (!$department) {
            throw new UnrecoverableMessageHandlingException("Department not found");
        }
        
        $employee = new Employee(
            name: $command->name,
            lastName: $command->lastName,
            department: $department,
            startDate: $command->startDate,
            wageBase: $command->wageBase,
            fixedYearlySupplementAmount: $command->fixedYearlySupplementAmount
        );
        
        $this->employeeRepository->save($employee);
    }
}