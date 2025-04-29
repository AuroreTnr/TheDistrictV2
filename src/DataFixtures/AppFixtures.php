<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Plat;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface as HasherUserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(HasherUserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();
        $faker->addProvider(new \FakerRestaurant\Provider\fr_FR\Restaurant($faker));

        //Categories
        $categorie1 = new Categorie();
        $categorie1->setLibelle('Burger');
        $categorie1->setImage('img/image-fixeture.jpg');
        $categorie1->setActive(true);
        $categorie1->setSlug(strtolower($categorie1->getLibelle()));
        $manager->persist($categorie1);

        $categorie2 = new Categorie();
        $categorie2->setLibelle('Pizza');
        $categorie2->setImage('img/image-fixeture.jpg');
        $categorie2->setActive(true);
        $categorie1->setSlug(strtolower($categorie2->getLibelle()));
        $manager->persist($categorie2);

        $categorie3 = new Categorie();
        $categorie3->setLibelle('Veggie');
        $categorie3->setImage('img/image-fixeture.jpg');
        $categorie3->setActive(true);
        $categorie1->setSlug(strtolower($categorie3->getLibelle()));
        $manager->persist($categorie3);


        // Plats
        for ($i=0; $i < 5 ; $i++) { 
            $plat = new Plat();
            $plat->setLibelle('Burger' . $i);
            $plat->setDescription($faker->text(5));
            $plat->setPrix('10');
            $plat->setImage('img/image-fixeture.jpg');
            $plat->setActive(true);
            $plat->setCategorie($faker->randomElement([$categorie1, $categorie2, $categorie3]));
            $plat->setSlug(strtolower('burger-' . $i));
            $plat->setTva(5.5);
            $manager->persist($plat);
        }


        // Utilisateurs

        //Admin
        $userAdmin = new User();
        $userAdmin->setNom('admin');
        $userAdmin->setPrenom('test');
        $userAdmin->setRoles(['ROLE_ADMIN']);
        $userAdmin->setEmail('admin@test.fr');
        $userAdmin->setPassword($this->passwordHasher->hashPassword($userAdmin, '1234'));
        $manager->persist($userAdmin);


        // Chef
        $userChef = new User();
        $userChef->setNom('chef');
        $userChef->setPrenom('test');
        $userChef->setRoles(['ROLE_CHEF']);
        $userChef->setEmail('chef@test.fr');
        $userChef->setPassword($this->passwordHasher->hashPassword($userChef, '1234'));
        $manager->persist($userChef);


        // Client
        $userClient = new User();
        $userClient->setNom('user');
        $userClient->setPrenom('test');
        $userClient->setRoles([]);
        $userClient->setEmail('client@test.fr');
        $userClient->setPassword($this->passwordHasher->hashPassword($userClient, '1234'));
        $manager->persist($userClient);
   


        $manager->flush();


    }
}
