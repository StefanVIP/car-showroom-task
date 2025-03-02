<?php

declare(strict_types=1);

namespace App\DTO\Request;

use OpenApi\Annotations as OA;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @OA\Schema(
 *     description="Данные для создания заявки на кредит",
 *     type="object"
 * )
 */
class PostCreditDTO
{
    /**
     * @OA\Property(type="integer", example=1)
     * @Assert\NotBlank(message="ИД автомобиля обязательна.")
     * @Assert\Type(type="integer", message="ИД должно быть целым числом.")
     */
    private int $carId;

    /**
     * @OA\Property(type="integer", example=1)
     * @Assert\NotBlank(message="ИД программы обязательна.")
     * @Assert\Type(type="integer", message="ИД должно быть целым числом.")
     */
    private int $programId;

    /**
     * @OA\Property(type="integer", example=200000)
     * @Assert\NotBlank(message="Первоначальный взнос обязателен.")
     * @Assert\Type(type="int", message="Первоначальный взнос должен быть числом.")
     * @Assert\Positive(message="Первоначальный взнос должен быть положительным числом.")
     */
    private int $initialPayment;

    /**
     * @OA\Property(type="integer", example=36)
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

    public function __construct(int $carId, int $programId, int $initialPayment, int $loanTerm)
    {
        $this->carId = $carId;
        $this->programId = $programId;
        $this->initialPayment = $initialPayment;
        $this->loanTerm = $loanTerm;
    }

    public function getCarId(): int
    {
        return $this->carId;
    }

    public function getProgramId(): int
    {
        return $this->programId;
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
