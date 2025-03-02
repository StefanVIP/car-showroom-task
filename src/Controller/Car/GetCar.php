<?php

declare(strict_types=1);

namespace App\Controller\Car;

use App\DTO\Response\CarDTO;
use App\Entity\Car\Car;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @OA\Tag(name="Car") */
class GetCar extends AbstractController
{
    /**
     * Получить информацию об автомобиле по ID.
     *
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID автомобиля",
     * @OA\Schema(type="integer")
     * )
     *
     * @OA\Response(
     * response=200,
     * description="Возвращает информацию об автомобиле",
     * @OA\JsonContent(ref=@Model(type=CarDTO::class))
     * )
     *
     * @OA\Response(
     * response=404,
     * description="Автомобиль не найден",
     * @OA\JsonContent(
     * type="object",
     * @OA\Property(property="error", type="string", example="Автомобиль не найден")
     * )
     * )
     * @Route("/api/v1/cars/{id}", methods={"GET"})
     */
    public function __invoke(Car $car): JsonResponse
    {
        return $this->json(CarDTO::create($car), Response::HTTP_OK);
    }
}
