<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture implements DependentFixtureInterface
{
    public const CAR_REFERENCE = 'car';

    public function load(ObjectManager $manager): void
    {
        $brand1 = $this->getReference(BrandFixtures::BRAND_REFERENCE . 'Toyota');
        $model1 = $this->getReference(ModelFixtures::MODEL_REFERENCE . 'Camry');
        $car1 = new Car($brand1, $model1, 'toyota-camry.jpg', 2500000);
        $manager->persist($car1);
        $this->addReference(self::CAR_REFERENCE . 1, $car1);

        $brand2 = $this->getReference(BrandFixtures::BRAND_REFERENCE . 'Honda');
        $model2 = $this->getReference(ModelFixtures::MODEL_REFERENCE . 'Civic');
        $car2 = new Car($brand2, $model2, 'honda-civic.jpg', 1800000);
        $manager->persist($car2);
        $this->addReference(self::CAR_REFERENCE . 2, $car2);

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [BrandFixtures::class, ModelFixtures::class];
    }
}
