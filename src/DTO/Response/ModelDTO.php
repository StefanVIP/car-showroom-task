<?php

namespace App\DTO\Response;

use App\Entity\Car\Model;

class ModelDTO
{
    private int $id;
    private string $name;

    public static function create(Model $model): self
    {
        $response = new self();
        $response->id = $model->getId();
        $response->name = $model->getName();

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
