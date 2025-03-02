<?php

namespace App\DTO\Response;

use App\Entity\Car\Brand;

class BrandDTO
{
    private int $id;
    private string $name;

    public static function create(Brand $brand): self
    {
        $response = new self();
        $response->id = $brand->getId();
        $response->name = $brand->getName();

        return $response;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
