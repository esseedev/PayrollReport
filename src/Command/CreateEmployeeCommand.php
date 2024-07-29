<?php

namespace App\Command;

use App\Entity\Department;
use DateTimeImmutable;

class CreateEmployeeCommand
{
    public function __construct
    (
        public string $name,
        public string $lastName,
        public Department $department,
        public DateTimeImmutable $startDate,
        public int $wageBase,
        public int $fixedYearlySupplementAmount
    ) {}
}
