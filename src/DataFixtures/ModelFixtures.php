<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModelFixtures extends Fixture implements DependentFixtureInterface
{
    public const MODEL_REFERENCE = 'model';

    public function load(ObjectManager $manager): void
    {
        $brand1 = $this->getReference(BrandFixtures::BRAND_REFERENCE . 'Toyota');
        $model1 = new Model($brand1, 'Camry');
        $manager->persist($model1);
        $this->addReference(self::MODEL_REFERENCE . $model1->getName(), $model1);

        $brand2 = $this->getReference(BrandFixtures::BRAND_REFERENCE . 'Honda');
        $model2 = new Model($brand2, 'Civic');
        $manager->persist($model2);
        $this->addReference(self::MODEL_REFERENCE . $model2->getName(), $model2);

        $manager->flush();
        $manager->clear();
    }

    public function getDependencies(): array
    {
        return [BrandFixtures::class];
    }
}
