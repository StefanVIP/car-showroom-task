<?php

declare(strict_types=1);

namespace App\Controller\Credit;

use App\DTO\Request\PostCreditDTO;
use App\Service\CreditService;
use App\Validator\RequestValidator;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @OA\Tag(name="Credit") */
class CreateCreditRequest extends AbstractController
{
    /**
     * Создать заявку на кредит.
     *
     * @OA\RequestBody(
     * description="Данные для создания кредитной заявки",
     * required=true,
     * @OA\JsonContent(ref=@Model(type=PostCreditDTO::class))
     * )
     *
     * @OA\Response(
     * response=201,
     * description="Кредитная заявка успешно создана",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="success", type="boolean", example=true)
     * )
     * )
     *
     * @OA\Response(
     * response=400,
     * description="Некорректные данные запроса",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="error", type="string", example="Некорректные данные запроса")
     * )
     * )
     *
     * @OA\Response(
     * response=404,
     * description="Автомобиль или кредитная программа не найдены",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="error", type="string", example="Автомобиль или кредитная программа не найдены")
     * )
     * )
     * @Route("/api/v1/credit/request", methods={"POST"})
     */
    public function createRequest(
        Request $request,
        CreditService $creditService,
        RequestValidator $requestValidator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $dto = $requestValidator->validateAndDenormalize($data, PostCreditDTO::class);

        $creditService->createCreditRequest($dto);

        return $this->json(['success' => true], Response::HTTP_CREATED);
    }
}
