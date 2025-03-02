<?php

declare(strict_types=1);

namespace App\Entity\Car;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 * @ORM\Table(name="brands")
 */
class Brand
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @phpstan-ignore-next-line
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
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
