<?php
declare(strict_types=1);

namespace App\Command;

use DateTimeImmutable;
use DateTimeInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateEmployeeCommand
{
    public function __construct
    (
        #[Assert\NotBlank(message: "Employee name cannot be blank.")]
        #[Assert\Length(
            min:2,
            max: 255,
            minMessage: "Employee name must be at least {{ limit }} characters long.",
            maxMessage: "Employee name cannot be longer than {{ limit }} characters.")]
        public string $name,
        
        #[Assert\NotBlank(message: "Employee last name cannot be blank.")]
        #[Assert\Length(
            min:2,
            max: 255,
            minMessage: "Employee last name must be at least {{ limit }} characters long.",
            maxMessage: "Employee last name cannot be longer than {{ limit }} characters.")]
        public string $lastName,
        
        #[Assert\NotBlank(message: "Department ID cannot be blank.")]
        #[Assert\Positive(message: "Department ID must be a positive number.")]
        public int $departmentId,
        
        #[Assert\NotBlank(message: "Start date cannot be blank")]
        #[Assert\Type(
            type: DateTimeInterface::class,
            message: "Start date must be a valid date.",
        )]
        public DateTimeImmutable $startDate,
        
        #[Assert\NotBlank(message: "Wage base cannot be blank.")]
        #[Assert\PositiveOrZero(message: "Wage base must be zero or a positive number.")]
        public int $wageBase,
        
        #[Assert\NotBlank(message: "Fixed yearly supplement amount cannot be blank.")]
        #[Assert\PositiveOrZero(message: "Fixed yearly supplement must be zero or a positive number.")]
        public int $fixedYearlySupplementAmount
    ) {}
}
