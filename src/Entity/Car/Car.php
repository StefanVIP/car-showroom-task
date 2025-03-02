<?php

declare(strict_types=1);

namespace App\Entity\Car;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity(repositoryClass="App\Repository\CarRepository") */
class Car
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @phpstan-ignore-next-line
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car\Brand")
     * @ORM\JoinColumn(nullable=false)
     * @var Brand
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car\Model")
     * @ORM\JoinColumn(nullable=false)
     * @var Model
     */
    private $model;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $photo;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $price;

    public function __construct(Brand $brand, Model $model, string $photo, int $price)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->photo = $photo;
        $this->price = $price;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getModel(): Model
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
