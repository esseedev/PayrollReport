<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Employee;

class SalaryCalculatorService
{
    public function calculateSalary(Employee $employee): int {
        $wageBase = $employee->getWageBase();
        $department = $employee->getDepartment();

        if ($department->isPercentageBased()) {
            return $wageBase + (int)round($wageBase * ($department->getSupplementPercentage() / 100));
        }
        
        $yearsOfService = min($employee->getYearsOfService(), 10);
        return $wageBase + (int)round($employee->getFixedYearlySupplementAmount() * $yearsOfService);
    }

    public function calculateSupplement(Employee $employee): int {
        $totalSalary = $this->calculateSalary($employee);
        return $totalSalary - $employee->getWageBase();
    }
}