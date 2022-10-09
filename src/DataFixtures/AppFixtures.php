<?php

namespace App\DataFixtures;

use App\DataFixtures\Provider\AppProvider;
use Faker\ORM\Doctrine\Populator;
use Faker;
use App\Entity\Author;
use App\Entity\Post;
use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {

        // ! config du faker et du populator
        $faker = Faker\Factory::create('fr_FR');

        $populator = new Populator($faker,$manager);

        
        $populator->addEntity(Author::class,5,[
            'firstname' => function() use ($faker) { return $faker->word(1); },
            'lastname' => function() use ($faker) { return $faker->word(1); },
            'createdAt' => function() use ($faker) { return \DateTimeImmutable::createFromMutable($faker->dateTime()); },
        ]);
        
        $populator->addEntity(Post::class,20,[
            'title' => function() use ($faker) { return $faker->word(3); },
            'body' => function() use ($faker) { return $faker->text(); },
            'publishedAt' => function() use ($faker) { return \DateTimeImmutable::createFromMutable($faker->dateTime()); },
            'image' => function()  { return "https://picsum.photos/200/300"; },
        ]);
        // Ici j'ai un tableau avec tous mes objets ajouté en bdd
        $insertedItems = $populator->execute();

        $authorsList = [];

        foreach($insertedItems['App\Entity\Author'] as $author) {
            $author->__construct();
            $authorsList[] = $author;
        }

        foreach($insertedItems['App\Entity\Post'] as $post) {
            $post->__construct();
            $rand = array_rand($authorsList);
            $post->setAuthor($authorsList[$rand]);
        }

        $admin = new User();
        $admin->setEmail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword('$2y$13$pqGG/JGCx3FfThX44eypu.pnShyRZRxePiBTKhI9J56ZDTDn6S8LO');
        $user = new User();
        $user->setEmail('user@user.com');
        $user->setRoles(['ROLE_USER']);
        $user->setPassword('$2y$13$M6skzIO627KGeGbzTbQYfu6QLIg4XXFv0wFV5DyvKgdfiDa/mzYLe');

       $manager->persist($admin); 
       $manager->persist($user); 

        $manager->flush();
    }
}
