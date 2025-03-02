<?php

declare(strict_types=1);

namespace App\Entity\Credit;

use App\Entity\Car\Car;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditRequestRepository")
 * @ORM\Table(name="credit_requests")
 * @ORM\HasLifecycleCallbacks
 */
class CreditRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @phpstan-ignore-next-line
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car\Car")
     * @ORM\JoinColumn(nullable=false)
     * @var Car
     */
    private Car $car;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Credit\CreditProgram")
     * @ORM\JoinColumn(nullable=false)
     * @var CreditProgram
     */
    private CreditProgram $program;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $initialPayment;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private int $loanTerm;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @var \DateTimeImmutable
     */
    private \DateTimeImmutable $createdAt;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private \DateTime $updatedAt;

    public function __construct(Car $car, CreditProgram $program, int $initialPayment, int $loanTerm)
    {
        $this->car = $car;
        $this->program = $program;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): Car
    {
        return $this->car;
    }

    public function getProgram(): CreditProgram
    {
        return $this->program;
    }

    public function getInitialPayment(): int
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /** @ORM\PreUpdate */
    public function updateTimestamps(): void
    {
        $this->updatedAt = new \DateTime();
    }
}
