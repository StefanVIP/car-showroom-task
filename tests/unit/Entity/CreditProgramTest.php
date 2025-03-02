<?php

namespace App\Tests\unit\Entity;

use App\Entity\Car\Brand;
use App\Entity\Car\Car;
use App\Entity\Car\Model;
use App\Entity\Credit\CreditProgram;
use App\Entity\Credit\CreditRequest;
use PHPUnit\Framework\TestCase;

class CreditProgramTest extends TestCase
{
    public function testCarEntity(): void
    {
        $brand = new Brand('Toyota');

        $model = new Model($brand, 'Camry');

        $car = new Car($brand, $model, 'toyota.jpg', 2500000);
        $program = new CreditProgram('Super profit', 2.9);
        $request = new CreditRequest($car, $program, 300000, 36);

        $this->assertNull($request->getId());
        $this->assertSame(2500000, $request->getCar()->getPrice());
        $this->assertSame('Super profit', $request->getProgram()->getTitle());
        $this->assertSame(300000, $request->getInitialPayment());
        $this->assertSame(36, $request->getLoanTerm());
        $this->assertNotNull($request->getCreatedAt());

        $updatedAt = $request->getUpdatedAt();
        $this->assertNotNull($updatedAt);
        $request->updateTimestamps();
        $this->assertNotSame($request->getUpdatedAt(), $updatedAt);
    }
}
