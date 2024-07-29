<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function __construct
    (
        #[ORM\Column(length: 255)]
        private string $name,

        #[ORM\Column]
        private bool $isPercentageBased,

        #[ORM\Column(nullable: true)]
        private ?float $supplementPercentage = null
    ) {}

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

    public function isPercentageBased(): bool
    {
        return $this->isPercentageBased;
    }

    public function setIsPercentageBased(bool $isPercentageBased): void
    {
        $this->isPercentageBased = $isPercentageBased;
    }

    public function getSupplementPercentage(): ?float
    {
        return $this->supplementPercentage;
    }

    public function setSupplementPercentage(?float $supplementPercentage): void
    {
        $this->supplementPercentage = $supplementPercentage;
    }
}
