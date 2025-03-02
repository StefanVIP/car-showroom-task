<?php

declare(strict_types=1);

namespace App\Entity\Credit;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CreditProgramRepository")
 * @ORM\Table(name="credit_programs")
 */
class CreditProgram
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @phpstan-ignore-next-line
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private string $title;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=1)
     * @var float
     */
    private float $interestRate;

    public function __construct(string $title, float $interestRate)
    {
        $this->title = $title;
        $this->interestRate = $interestRate;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }
}
