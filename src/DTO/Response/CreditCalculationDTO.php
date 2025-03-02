<?php

namespace App\DTO\Response;

use App\Entity\Credit\CreditProgram;

class CreditCalculationDTO
{
    private int $programId;
    private float $interestRate;
    private int $monthlyPayment;
    private string $title;

    public static function create(CreditProgram $program, int $monthlyPayment): self
    {
        $response = new self();
        $response->programId = $program->getId();
        $response->interestRate = $program->getInterestRate();
        $response->monthlyPayment = $monthlyPayment;
        $response->title = $program->getTitle();

        return $response;
    }

    public function getProgramId(): int
    {
        return $this->programId;
    }

    public function getInterestRate(): float
    {
        return $this->interestRate;
    }

    public function getMonthlyPayment(): int
    {
        return $this->monthlyPayment;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
