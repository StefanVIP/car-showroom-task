<?php

namespace App\Service;

use App\DTO\Request\GetCreditCalculationDTO;
use App\DTO\Request\PostCreditDTO;
use App\Entity\Credit\CreditProgram;
use App\Entity\Credit\CreditRequest;
use App\Repository\CarRepository;
use App\Repository\CreditProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreditService
{
    private EntityManagerInterface $em;
    private CarRepository $carRepository;
    private CreditProgramRepository $programRepository;

    public function __construct(
        EntityManagerInterface $em,
        CarRepository $carRepository,
        CreditProgramRepository $programRepository
    ) {
        $this->em = $em;
        $this->carRepository = $carRepository;
        $this->programRepository = $programRepository;
    }

    public function calculateMonthlyPayment(
        float $sum,
        float $rate,
        int $term
    ): int {
        $monthlyRate = $rate / 12 / 100;
        $coefficient = $monthlyRate * pow(1 + $monthlyRate, $term) / (pow(1 + $monthlyRate, $term) - 1);
        return (int)($sum * $coefficient);
    }

    public function selectCreditProgram(
        GetCreditCalculationDTO $dto,
        CreditProgramRepository $programRepository
    ): CreditProgram {
        if ($dto->getPermissibleMonthlyPayment() <= 10000
            && $dto->getInitialPayment() >= 200000
            && $dto->getLoanTerm() <= 60) {
            return $programRepository->findOneBy(['id' => 1]);
        }

        return $programRepository->findOneBy(['id' => 2]);
    }

    public function createCreditRequest(PostCreditDTO $dto): void
    {
        $car = $this->carRepository->findOneBy(['id' => $dto->getCarId()]);
        $program = $this->programRepository->findOneBy(['id' => $dto->getProgramId()]);

        if ($car === null) {
            throw new NotFoundHttpException('Машина с таким ID не найдена');
        }
        if ($program === null) {
            throw new NotFoundHttpException('Программа с таким ID не найдена');
        }

        $creditRequest = new CreditRequest($car, $program, $dto->getInitialPayment(), $dto->getLoanTerm());

        $this->em->persist($creditRequest);
        $this->em->flush();
    }
}
