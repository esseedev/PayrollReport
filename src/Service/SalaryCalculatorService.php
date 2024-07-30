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
            //TODO: Wyjeb supplement powtorzenie
            $supplement = $wageBase * ($department->getSupplementPercentage() / 100);
        } else {
            $yearsOfService = min($employee->getYearsOfService(), 10);
            $supplement = $employee->getFixedYearlySupplementAmount() * $yearsOfService;
        }

        return $wageBase + $supplement;
    }

    public function calculateSupplement(Employee $employee): int {
        $totalSalary = $this->calculateSalary($employee);
        return $totalSalary - $employee->getWageBase();
    }
}