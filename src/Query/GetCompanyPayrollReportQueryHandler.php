<?php

namespace App\Query;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Services\SalaryCalculatorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetCompanyPayrollReportQueryHandler
{
    public function __construct
    (
        private EmployeeRepository $employeeRepository,
        private SalaryCalculatorService $salaryCalculator,
    ) {}
    
    public function __invoke(GetCompanyPayrollReportQuery $query):array {
        $employees = $this->employeeRepository->findByFilters(
            department: $query->filterDepartment,
            name: $query->filterName,
            lastName: $query->filterLastName
        );
        
        if ($query->sortBy) {
            usort($employees, fn($a, $b) => $a->{$query->sortBy} <=> $b->{$query->sortBy});
        }
        
        return array_map(function (Employee $employee) {
            $totalSalary = $this->salaryCalculator->calculateSalary($employee);
            $supplement = $this->salaryCalculator->calculateSupplement($employee);
            
            return [
                'firstName' => $employee->getName(),
                'lastName' => $employee->getLastName(),
                'department' => $employee->getDepartment()->getName(),
                'baseSalary' => $employee->getWageBase(),
                'supplement' => $supplement,
                'supplementType' => $employee->getDepartment()->isPercentageBased() ? '%' : 'fixed',
                'totalSalary' => $totalSalary,
            ];
        }, $employees);
    }
}