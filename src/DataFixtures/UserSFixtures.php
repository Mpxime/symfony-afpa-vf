<?php

namespace App\DataFixtures;

use App\Entity\UserS;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
//use Symfony\Component\String\Slugger\SluggerInterface;
use Faker;

class UserSFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordEncoder,
        //private SluggerInterface $slugger
    ){}

    public function load(ObjectManager $manager): void
    {
        $admin = new UserS();
        $admin->setLastname('test');
        $admin->setFirstname('test');
        $admin->setAddress('test');
        $admin->setCity('test');
        $admin->setZipcode('test');
        $admin->setEmail('admin@test.com');
        $admin->setPassword(
            $this->passwordEncoder->hashPassword($admin,'admintest')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Faker\Factory::create('fr_FR');

        for($usr = 1; $usr <= 3; $usr++){
            $user = new UserS();
            $user->setLastname($faker->lastname);
            $user->setFirstname($faker->firstname);
            $user->setAddress($faker->streetAddress);
            $user->setCity($faker->city);
            $user->setZipcode(str_replace(' ', '', $faker->postcode)); // remplace les espaces par rien dans le zipcode(postcode)
            $user->setEmail($faker->email);
            $user->setPassword(
                $this->passwordEncoder->hashPassword($user,'usertest')
            );


            //dump($user); //vu des donnees dans la console
            

            $manager->persist($user);
    
        }

        $manager->flush();
    }
}
