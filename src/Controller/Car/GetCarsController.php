<?php

declare(strict_types=1);

namespace App\Controller\Car;

use App\DTO\Response\CarShortDTO;
use App\Repository\CarRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @OA\Tag(name="Car") */
class GetCarsController extends AbstractController
{
    /**
     * Получить список автомобилей.
     *
     * @OA\Response(
     * response=200,
     * description="Возвращает список автомобилей",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref=@Model(type=CarShortDTO::class))
     * )
     * )
     *
     * @Route("/api/v1/cars", methods={"GET"})
     */
    public function __invoke(CarRepository $repository): JsonResponse
    {
        $cars = $repository->findAll();
        $carsDTO = array_map(fn($car) => CarShortDTO::create($car), $cars);

        return $this->json($carsDTO, Response::HTTP_OK);
    }
}
