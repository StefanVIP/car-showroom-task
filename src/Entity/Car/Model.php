<?php

declare(strict_types=1);

namespace App\Entity\Car;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ModelRepository")
 * @ORM\Table(name="models")
 */
class Model
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @phpstan-ignore-next-line
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Car\Brand")
     * @ORM\JoinColumn(nullable=false)
     * @var Brand
     */
    private Brand $brand;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $name;

    public function __construct(Brand $brand, string $name)
    {
        $this->brand = $brand;
        $this->name = $name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getBrand(): Brand
    {
        return $this->brand;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
