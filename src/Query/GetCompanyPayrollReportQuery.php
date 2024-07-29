<?php

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