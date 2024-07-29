<?php
declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Validator\Constraints as Assert;

class CreateDepartmentCommand
{
    public function __construct
    (
        #[Assert\NotBlank(message: "Department name cannot be blank.")]
        #[Assert\Length(
            min: 2,
            max: 255,
            minMessage: "Department name must be at least {{ limit }} characters long.",
            maxMessage: "Department name cannot be longer than {{ limit }} characters.")]
        public string $name,
        
        #[Assert\NotNull(message: "Is percentage based must be specified.")]
        #[Assert\Type(
            type: "bool",
            message: "The value {{ value }} is not a valid {{ type}}."
        )]
        public bool $isPercentageBased,
        
        #[Assert\Type(
            type: "float",
            message: "The value {{ value }} is not a valid {{ type }}."
        )]
        #[Assert\Expression(
            expression: "this.isPercentageBased == false or value != null",
            message: "Supplement percentage is required when percentage-based."
        )]
        public ?float $supplementPercentage = null
    ) {}
}