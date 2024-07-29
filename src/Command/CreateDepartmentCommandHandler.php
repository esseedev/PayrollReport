<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateDepartmentCommandHandler
{
    public function __construct
    (
        private EntityManagerInterface $entityManager
    )
    { }
    
    public function __invoke(#[MapRequestPayload] CreateDepartmentCommand $command): void {
        $department = new Department(
            $command->name,
            $command->isPercentageBased,
            $command->supplementPercentage
        );
        
        $this->entityManager->persist($department);
        $this->entityManager->flush();
    }
}