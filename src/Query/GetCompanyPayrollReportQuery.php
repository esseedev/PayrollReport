<?php
declare(strict_types=1);

namespace App\Query;

class GetCompanyPayrollReportQuery
{
    public function __construct
    (
        public ?string $sortBy = null,
        public ?string $filterDepartment = null,
        public ?string $filterName = null,
        public ?string $filterLastName = null
    ) { }
}