<?php

namespace App\Command;

class CreateDepartmentCommand
{
    public function __construct
    (
        public string $name,
        public bool $isPercentageBased,
        public ?float $supplementPercentage = null
    ) {}
}