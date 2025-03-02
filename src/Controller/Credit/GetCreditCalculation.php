<?php

declare(strict_types=1);

namespace App\Controller\Credit;

use App\DTO\Request\GetCreditCalculationDTO;
use App\DTO\Response\CreditCalculationDTO;
use App\Repository\CreditProgramRepository;
use App\Service\CreditService;
use App\Validator\RequestValidator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @OA\Tag(name="Credit") */
class GetCreditCalculation extends AbstractController
{
    /**
     * Рассчитать кредитный платеж.
     *
     * @OA\Parameter(
     * name="price",
     * in="query",
     * description="Цена автомобиля",
     * @OA\Schema(type="integer", example=1000000)
     * )
     * @OA\Parameter(
     * name="permissibleMonthlyPayment",
     * in="query",
     * description="Допустимый ежемесячный платеж",
     * @OA\Schema(type="integer", example=20000)
     * )
     * @OA\Parameter(
     * name="initialPayment",
     * in="query",
     * description="Первоначальный взнос",
     * @OA\Schema(type="integer", example=200000)
     * )
     * @OA\Parameter(
     * name="loanTerm",
     * in="query",
     * description="Срок кредита (в месяцах)",
     * @OA\Schema(type="integer", example=36)
     * )
     *
     * @OA\Response(
     * response=200,
     * description="Возвращает информацию о кредитном расчете",
     * @OA\JsonContent(ref=@Model(type=CreditCalculationDTO::class))
     * )
     *
     * @OA\Response(
     * response=400,
     * description="Некорректные параметры запроса",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="error", type="string", example="Некорректные параметры запроса")
     * )
     * )
     *
     * @OA\Response(
     * response=404,
     * description="Кредитная программа не найдена",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="error", type="string", example="Кредитная программа не найдена")
     * )
     * )
     * @Route("/api/v1/credit/calculate", methods={"GET"})
     */
    public function __invoke(
        Request $request,
        CreditProgramRepository $programRepository,
        CreditService $creditService,
        RequestValidator $requestValidator
    ): JsonResponse {
        $data = [
            'price' => (int)$request->query->get('price'),
            'permissibleMonthlyPayment' => (int)$request->query->get('permissibleMonthlyPayment'),
            'initialPayment' => (int)$request->query->get('initialPayment'),
            'loanTerm' => (int)$request->query->get('loanTerm'),
        ];

        $dto = $requestValidator->validateAndDenormalize($data, GetCreditCalculationDTO::class);

        $program = $creditService->selectCreditProgram($dto, $programRepository);

        $creditSum = $dto->getPrice() - $dto->getInitialPayment();
        $monthlyPayment = $creditService->calculateMonthlyPayment(
            $creditSum,
            $program->getInterestRate(),
            $dto->getLoanTerm(),
        );

        return $this->json(CreditCalculationDTO::create($program, $monthlyPayment));
    }
}
