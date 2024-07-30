<?php
declare(strict_types=1);

namespace App\Command;

use App\Entity\Department;
use App\Repository\DepartmentRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateDepartmentCommandHandler
{
    public function __construct
    (
        private readonly DepartmentRepository $departmentRepository,
    )
    { }
    
    public function __invoke(CreateDepartmentCommand $command): void {
        $department = new Department(
            $command->name,
            $command->isPercentageBased,
            $command->supplementPercentage
        );
        
        $this->departmentRepository->save($department);
    }
}