<?php

namespace App\Tests\integration\Service;

use App\DTO\Request\GetCreditCalculationDTO;
use App\DTO\Request\PostCreditDTO;
use App\Entity\Car\Brand;
use App\Entity\Car\Car;
use App\Entity\Car\Model;
use App\Entity\Credit\CreditProgram;
use App\Entity\Credit\CreditRequest;
use App\Repository\CarRepository;
use App\Repository\CreditProgramRepository;
use App\Service\CreditService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CreditServiceTest extends TestCase
{
    public function testCalculateMonthlyPayment(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $carRepository = $this->createMock(CarRepository::class);
        $programRepository = $this->createMock(CreditProgramRepository::class);

        $creditService = new CreditService($em, $carRepository, $programRepository);

        $this->assertEquals(98854, $creditService->calculateMonthlyPayment(2100000, 12, 24));
    }

    public function testSelectCreditProgram(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $carRepository = $this->createMock(CarRepository::class);
        $programRepository = $this->createMock(CreditProgramRepository::class);

        $creditService = new CreditService($em, $carRepository, $programRepository);

        $program1 = new CreditProgram('Test 1', 13.5);
        $program2 = new CreditProgram('Test 2', 14.1);

        $programRepository
            ->method('findOneBy')
            ->willReturnCallback(function ($criteria) use ($program1, $program2) {
                return $criteria['id'] === 1 ? $program1 : $program2;
            });

        $dto1 = new GetCreditCalculationDTO(2300000, 9000, 250000, 48);

        $this->assertSame($program1, $creditService->selectCreditProgram($dto1, $programRepository));

        $dto2 = new GetCreditCalculationDTO(2300000, 15000, 100000, 72);

        $this->assertSame($program2, $creditService->selectCreditProgram($dto2, $programRepository));
    }

    public function testCreateCreditRequest(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $carRepository = $this->createMock(CarRepository::class);
        $programRepository = $this->createMock(CreditProgramRepository::class);

        $creditService = new CreditService($em, $carRepository, $programRepository);

        $brand = new Brand('Test Brand');
        $model = new Model($brand, 'Test Model');
        $car = new Car($brand, $model, 'photo.jpg', 1800000);
        $program = new CreditProgram('Test program', 9.9);

        $carRepository->method('findOneBy')->willReturn($car);
        $programRepository->method('findOneBy')->willReturn($program);

        $em
            ->expects($this->once())
            ->method('persist')
            ->with($this->isInstanceOf(CreditRequest::class));
        $em
            ->expects($this->once())
            ->method('flush');

        $dto = new PostCreditDTO(1, 1, 200000, 36);

        $creditService->createCreditRequest($dto);
    }

    public function testCreateCreditRequestCarNotFound(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $carRepository = $this->createMock(CarRepository::class);
        $programRepository = $this->createMock(CreditProgramRepository::class);

        $creditService = new CreditService($em, $carRepository, $programRepository);

        $carRepository->method('findOneBy')->willReturn(null);
        $programRepository->method('findOneBy')->willReturn(new CreditProgram('Test program', 9.9));

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Машина с таким ID не найдена');

        $dto = new PostCreditDTO(999, 1, 200000, 36);

        $creditService->createCreditRequest($dto);
    }

    public function testCreateCreditRequestProgramNotFound(): void
    {
        $em = $this->createMock(EntityManagerInterface::class);
        $carRepository = $this->createMock(CarRepository::class);
        $programRepository = $this->createMock(CreditProgramRepository::class);

        $creditService = new CreditService($em, $carRepository, $programRepository);

        $brand = new Brand('Test Brand');
        $model = new Model($brand, 'Test Model');
        $carRepository->method('findOneBy')->willReturn(new Car($brand, $model, 'photo.jpg', 1800000));
        $programRepository->method('findOneBy')->willReturn(null);
        
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('Программа с таким ID не найдена');

        $dto = new PostCreditDTO(1, 999, 200000, 36);

        $creditService->createCreditRequest($dto);
    }
}
