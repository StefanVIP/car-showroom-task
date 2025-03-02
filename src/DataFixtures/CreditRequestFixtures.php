<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Credit\CreditRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CreditRequestFixtures extends Fixture implements DependentFixtureInterface
{
    public const CREDIT_REQUEST_REFERENCE = 'credit_request';

    public function load(ObjectManager $manager): void
    {
        $car1 = $this->getReference(CarFixtures::CAR_REFERENCE . 1);
        $program1 = $this->getReference(CreditProgramFixtures::CREDIT_PROGRAM_REFERENCE . 1);
        $request1 = new CreditRequest($car1, $program1, 210000, 36);
        $manager->persist($request1);
        $this->addReference(self::CREDIT_REQUEST_REFERENCE . 1, $request1);

        $car2 = $this->getReference(CarFixtures::CAR_REFERENCE . 2);
        $program2 = $this->getReference(CreditProgramFixtures::CREDIT_PROGRAM_REFERENCE . 2);
        $request2 = new CreditRequest($car2, $program2, 150000, 60);
        $manager->persist($request2);
        $this->addReference(self::CREDIT_REQUEST_REFERENCE . 2, $request2);

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [CarFixtures::class, CreditProgramFixtures::class];
    }
}
