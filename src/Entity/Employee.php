<?php
declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;
    public function __construct
    (
        #[ORM\Column(length: 255)]
        private string $name,

        #[ORM\Column(length: 255)]
        private string $lastName,

        #[ORM\ManyToOne(targetEntity: Department::class)]
        #[ORM\JoinColumn(nullable: false)]
        private Department $department,

        #[ORM\Column]
        private DateTimeImmutable $startDate,

        #[ORM\Column]
        private int $wageBase,

        #[ORM\Column]
        private int $fixedYearlySupplementAmount
    )
    { }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): void
    {
        $this->department = $department;
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getWageBase(): int
    {
        return $this->wageBase;
    }

    public function setWageBase(int $wageBase): void
    {
        $this->wageBase = $wageBase;
    }

    public function getFixedYearlySupplementAmount(): int
    {
        return $this->fixedYearlySupplementAmount;
    }

    public function setFixedYearlySupplementAmount(
        int $fixedYearlySupplementAmount
    ): void {
        $this->fixedYearlySupplementAmount = $fixedYearlySupplementAmount;
    }

    public function getYearsOfService(): int {
        $now = new DateTimeImmutable();
        $interval = $now->diff($this->startDate);
        return $interval->y;
    }
}
