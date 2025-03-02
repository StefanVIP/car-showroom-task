<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Credit\CreditProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditProgramFixtures extends Fixture
{
    public const CREDIT_PROGRAM_REFERENCE = 'credit_program';

    public function load(ObjectManager $manager): void
    {
        $program1 = new CreditProgram('Alfa Energy', 12.3);
        $manager->persist($program1);
        $this->addReference(self::CREDIT_PROGRAM_REFERENCE . 1, $program1);

        $program2 = new CreditProgram('Affordable', 11.9);
        $manager->persist($program2);
        $this->addReference(self::CREDIT_PROGRAM_REFERENCE . 2, $program2);

        $manager->flush();
        $manager->clear();
    }
}
