<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $authorList = [];

        $michel = new Author();
        $michel->setFirstname('Michel');
        $michel->setLastname('Potin');
        $michel->setCreatedAt(new DateTimeImmutable());
        $authorList[] = $michel;
        $manager->persist($michel);

        $jacques = new Author();
        $jacques->setFirstname('Jacques');
        $jacques->setLastname('Retour');
        $jacques->setCreatedAt(new DateTimeImmutable());
        $authorList[] = $jacques;
        $manager->persist($jacques);

        
        for ($i = 0; $i < 20; $i++) {
            $rand = array_rand($authorList);
            $post = new Post();
            $post->setTitle('Lorem Ipsum '. $i);
            $post->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies placerat leo sit amet feugiat. Praesent sed efficitur enim, sit amet luctus massa. Curabitur pellentesque turpis turpis, ut ultricies risus luctus vel. Nam in enim at magna tempor scelerisque sit amet ac mauris. Suspendisse tempor, felis id ultricies sollicitudin, enim nunc imperdiet risus, vel mattis leo dui eget ante. Aenean. ');
            $post->setPublishedAt(new DateTimeImmutable());
            $post->setAuthor($authorList[$rand]);
            $post->setImage('<img src="https://fakeimg.pl/250x100/">');
            $manager->persist($post);
        }

        $manager->flush();
    }
}
