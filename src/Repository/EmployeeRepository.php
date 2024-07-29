<?php

namespace App\Repository;

use App\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Persistence\ManagerRegistry;

class EmployeeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }
    
    public function findByFilters(?string $department = null, ?string $name = null, $lastName = null): array {
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
       
       return $this->matching($criteria)->toArray();
    }
}