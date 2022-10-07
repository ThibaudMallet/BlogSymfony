<?php

namespace App\DataFixtures;

use App\Entity\Author;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AuthorFixtures extends Fixture
{
    public const MICHEL = 'michel';
    public const JACQUES = 'jacques';

    public function load(ObjectManager $manager): void
    {
        $michel = new Author();
        $michel->setFirstname('Michel');
        $michel->setLastname('Potin');
        $michel->setCreatedAt(new DateTimeImmutable());
        $manager->persist($michel);

        $jacques = new Author();
        $jacques->setFirstname('Jacques');
        $jacques->setLastname('Retour');
        $jacques->setCreatedAt(new DateTimeImmutable());
        $manager->persist($jacques);
        
        $manager->flush();

        $this->addReference(self::JACQUES, $jacques);
        $this->addReference(self::MICHEL, $michel);

    }
}
