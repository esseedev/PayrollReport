<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Department;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class DepartmentRepository 
{
    private EntityRepository $repository;

    function __construct
    (
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Department::class);
    }
    
    public function find(int $id): ?Department {
        return $this->repository->find($id);
    }

    public function save(Department $department): void {
        $this->entityManager->persist($department);
        $this->entityManager->flush();
    }
}