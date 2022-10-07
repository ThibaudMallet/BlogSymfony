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
        $manager->persist($michel);
        $authorList[] = $michel;

        $jacques = new Author();
        $jacques->setFirstname('Jacques');
        $jacques->setLastname('Retour');
        $jacques->setCreatedAt(new DateTimeImmutable());
        $manager->persist($jacques);
        $authorList[] = $jacques;

        $rand = array_rand($authorList);


         $post1 = new Post();
         $post1->setTitle('Lorem Ipsum');
         $post1->setBody('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies placerat leo sit amet feugiat. Praesent sed efficitur enim, sit amet luctus massa. Curabitur pellentesque turpis turpis, ut ultricies risus luctus vel. Nam in enim at magna tempor scelerisque sit amet ac mauris. Suspendisse tempor, felis id ultricies sollicitudin, enim nunc imperdiet risus, vel mattis leo dui eget ante. Aenean. ');
         $post1->setPublishedAt(new DateTimeImmutable());
         $post1->setAuthor($authorList[$rand]);
         $post1->setImage('<img src="https://fakeimg.pl/250x100/">');
         $manager->persist($post1);

         $post2 = new Post();
         $post2->setTitle('Ipsum Lorem');
         $post2->setBody('Curabitur pellentesque turpis turpis, ut ultricies risus luctus vel. Nam in enim at magna tempor scelerisque sit amet ac mauris. Suspendisse tempor, felis id ultricies sollicitudin, enim nunc imperdiet risus, vel mattis leo dui eget ante. Aenean.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ultricies placerat leo sit amet feugiat. Praesent sed efficitur enim, sit amet luctus massa.');
         $post2->setPublishedAt(new DateTimeImmutable());
         $post1->setAuthor($authorList[$rand]);
         $post2->setImage('<img src="https://fakeimg.pl/250x100/">');
         $manager->persist($post2);
        
        $manager->flush();
    }
}
