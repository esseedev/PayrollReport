<?php
declare(strict_types=1);

namespace App\Controller;

use App\Query\GetCompanyPayrollReportQuery;
use App\Query\GetCompanyPayrollReportQueryHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
final readonly class PayrollController
{
    public function __construct(private GetCompanyPayrollReportQueryHandler $queryHandler) { }
    
    #[Route('/payroll-report', name:'payroll_report', methods: ['GET'])]
    public function getPayrollReport(Request $request): JsonResponse {
        $query = new GetCompanyPayrollReportQuery(
            sortBy: $request->query->get('sortBy'),
            filterDepartment: $request->query->get('filterDepartment'),
            filterName: $request->query->get('filterName'),
            filterLastName: $request->query->get('filterLastName')
        );

        $report = $this->queryHandler->execute($query);

        return new JsonResponse($report);
    }
}