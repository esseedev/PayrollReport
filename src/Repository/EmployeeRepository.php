<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class EmployeeRepository
{
    private EntityRepository $repository;
    public function __construct
    (
        private EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(Employee::class);
    }
    
    public function findByFilters(?string $department = null, ?string $name = null, $lastName = null, ?string $sortBy = null, string $sortOrder = 'asc'): array {
       $criteria = Criteria::create();
       
       if ($department) {
           $criteria->andWhere(Criteria::expr()->eq('department.name', $department));
       }
       
       if ($name) {
           $criteria->andWhere(Criteria::expr()->contains('name', $name));
       }
       
       if ($lastName) {
           $criteria->andWhere(Criteria::expr()->contains('lastname', $lastName));
       }
       
       if ($sortBy) {
           $criteria->orderBy([$this->getSortField($sortBy) => $sortOrder]);
       }
       
       return $this->repository->matching($criteria)->toArray();
    }
    
    public function save(Employee $employee): void {
        $this->entityManager->persist($employee);
        $this->entityManager->flush();
    }
    
    private function getSortField(string $sortBy): string {
        return match ($sortBy) {
            'department' => 'department.name',
            default => $sortBy
        };
    }
}