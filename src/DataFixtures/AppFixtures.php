<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        $categorie = new Categorie();
        $categorie->setLibelle('burger');
        $categorie->setImage('image1.jpeg');
        $categorie->setActive(true);
        $manager->persist($categorie);

        $categorie = new Categorie();
        $categorie->setLibelle('pizza');
        $categorie->setImage('image2.jpeg');
        $categorie->setActive(true);
        $manager->persist($categorie);

        $categorie = new Categorie();
        $categorie->setLibelle('veggie');
        $categorie->setImage('image3.jpeg');
        $categorie->setActive(true);
        $manager->persist($categorie);

        for ($i=0; $i < 5 ; $i++) { 
            $plat = new Plat();
            $plat->setLibelle($faker->foodName());
            $plat->setDescription($faker->text(10));
            $plat->setPrix('10');
            $plat->setImage('image' . $i . '.jpeg');
            $plat->setActive(true);
            $manager->persist($plat);
        }

        for ($i=0; $i < 2; $i++) { 
            $user = new User();
            $user->setNom('nomuser' . $i);
            $user->setPrenom('prenomuser' . $i);
            $user->setRoles([]);
            $user->setEmail($faker->email());
            $user->setPassword($faker->password(4,10));
            $manager->persist($user);
        }



        // $product = new Product();
        // $manager->persist($product);


        $manager->flush();


    }
}
