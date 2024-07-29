<?php

namespace App\Command;

use App\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateEmployeeCommandHandler
{
    public function __construct
    (
        private EntityManagerInterface $entityManager
    )
    { }
    
    public function __invoke(CreateEmployeeCommand $command) {
        $employee = new Employee(
            name: $command->name,
            lastName: $command->lastName,
            department: $command->department,
            startDate: $command->startDate,
            wageBase: $command->wageBase,
            fixedYearlySupplementAmount: $command->fixedYearlySupplementAmount
        );
        
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
    }
}