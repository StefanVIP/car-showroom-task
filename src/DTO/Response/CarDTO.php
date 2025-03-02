<?php

namespace App\DTO\Response;

use App\Entity\Car\Car;

class CarDTO
{
    private int $id;
    private BrandDTO $brand;
    private ModelDTO $model;
    private string $photo;
    private int $price;

    public static function create(Car $car): self
    {
        $response = new self();
        $response->id = $car->getId();
        $response->brand = BrandDTO::create($car->getBrand());
        $response->model = ModelDTO::create($car->getModel());
        $response->photo = $car->getPhoto();
        $response->price = $car->getPrice();

        return $response;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): BrandDTO
    {
        return $this->brand;
    }

    public function getModel(): ModelDTO
    {
        return $this->model;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
