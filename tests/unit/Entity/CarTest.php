<?php

namespace App\Tests\unit\Entity;

use App\Entity\Car\Brand;
use App\Entity\Car\Car;
use App\Entity\Car\Model;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testCarEntity(): void
    {
        $brand = new Brand('Toyota');

        $model = new Model($brand, 'Camry');

        $car = new Car($brand, $model, 'toyota.jpg', 2500000);

        $this->assertNull($car->getId());
        $this->assertSame('Toyota', $car->getBrand()->getName());
        $this->assertSame('Toyota', $car->getModel()->getBrand()->getName());
        $this->assertSame('Camry', $car->getModel()->getName());
        $this->assertSame(2500000, $car->getPrice());
        $this->assertSame('toyota.jpg', $car->getPhoto());
    }
}
