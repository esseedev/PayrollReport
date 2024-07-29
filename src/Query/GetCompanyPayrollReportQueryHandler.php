<?php
declare(strict_types=1);

namespace App\Query;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Service\SalaryCalculatorService;
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
        $startMemory = memory_get_usage(true);
        error_log("Handler start memory usage: " . $startMemory);
        
        $employees = $this->employeeRepository->findByFilters(
            department: $query->filterDepartment,
            name: $query->filterName,
            lastName: $query->filterLastName,
            sortBy: $query->sortBy,
            sortOrder: $query->sortOrder ?? 'ASC'
        );
        
        $afterQueryMemory = memory_get_usage(true);
        error_log("After query memory usage: " . $afterQueryMemory);
        error_log("Query memory difference: " . ($afterQueryMemory - $startMemory));
        
        $result = array_map(function (Employee $employee) {
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
        
        $endMemory = memory_get_usage(true);
        error_log("Handler end memory usage: " . $endMemory);
        error_log("Handler total memory difference: " . ($endMemory - $startMemory));

        return $result;
    }
}