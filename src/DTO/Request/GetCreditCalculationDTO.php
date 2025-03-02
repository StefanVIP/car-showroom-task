<?php

declare(strict_types=1);

namespace App\DTO\Request;

use Symfony\Component\Validator\Constraints as Assert;

final class GetCreditCalculationDTO
{
    /**
     * @Assert\NotBlank(message="Цена обязательна.")
     * @Assert\Type(type="integer", message="Цена должна быть целым числом.")
     * @Assert\Positive(message="Цена должна быть положительным числом.")
     */
    private int $price;

    /**
     * @Assert\NotBlank(message="Платёж в месяц обязателен.")
     * @Assert\Type(type="integer", message="Платёж в месяц должен быть целым числом.")
     * @Assert\Positive(message="Платёж в месяц должен быть положительным числом.")
     */
    private int $permissibleMonthlyPayment;

    /**
     * @Assert\NotBlank(message="Первоначальный взнос обязателен.")
     * @Assert\Type(type="integer", message="Первоначальный взнос должен быть числом.")
     * @Assert\Positive(message="Первоначальный взнос должен быть положительным числом.")
     */
    private int $initialPayment;

    /**
     * @Assert\NotBlank(message="Срок кредита обязателен.")
     * @Assert\Type(type="integer", message="Срок кредита должен быть целым числом.")
     * @Assert\Positive(message="Срок кредита должен быть положительным числом.")
     * @Assert\Range(
     *     min=6,
     *     max=120,
     *     notInRangeMessage="Срок кредита должен быть от {{ min }} до {{ max }} месяцев."
     * )
     */
    private int $loanTerm;

    public function __construct(int $price, int $permissibleMonthlyPayment, int $initialPayment, int $loanTerm)
    {
        $this->price = $price;
        $this->permissibleMonthlyPayment = $permissibleMonthlyPayment;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getPermissibleMonthlyPayment(): int
    {
        return $this->permissibleMonthlyPayment;
    }

    public function getInitialPayment(): int
    {
        return $this->initialPayment;
    }

    public function getLoanTerm(): int
    {
        return $this->loanTerm;
    }
}
