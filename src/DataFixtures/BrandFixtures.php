<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Car\Brand;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BrandFixtures extends Fixture
{
    public const BRAND_REFERENCE = 'brand';

    public function load(ObjectManager $manager): void
    {
        $brand1 = new Brand('Toyota');
        $manager->persist($brand1);
        $this->addReference(self::BRAND_REFERENCE . $brand1->getName(), $brand1);

        $brand2 = new Brand('Honda');
        $manager->persist($brand2);
        $this->addReference(self::BRAND_REFERENCE . $brand2->getName(), $brand2);

        $manager->flush();
        $manager->clear();
    }
}
