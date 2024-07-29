<?php

namespace App\Controller;

use App\Query\GetCompanyPayrollReportQuery;
use App\Query\GetCompanyPayrollReportQueryHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PayrollController extends AbstractController
{
    #[Route('/payroll-report', name:'payroll_report', methods: ['GET'])]
    public function getPayrollReport(Request $request, GetCompanyPayrollReportQueryHandler $queryHandler): JsonResponse {
        $query = new GetCompanyPayrollReportQuery(
            sortBy: $request->query->get('sortBy'),
            filterDepartment: $request->query->get('filterDepartment'),
            filterName: $request->query->get('filterName'),
            filterLastName: $request->query->get('filterLastName')
        );

        $report = $queryHandler($query);

        return $this->json($report);
    }
}