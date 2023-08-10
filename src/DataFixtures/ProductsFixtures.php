<?php

namespace App\DataFixtures;

use App\Entity\Products;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use symfony\component\String\Slugger\SluggerInterface;
use Faker;

class ProductsFixtures extends Fixture
{

    //public function __construct(private SluggerInterface $slugger){} //si utilisation de fonction slug

    public function load(ObjectManager $manager): void
    {
        $faker = Faker\Factory::create('fr_FR');

        for($prdct = 1; $prdct <= 12; $prdct++){
            $product = new Products();
            $product->setName($faker->text(6));
            $product->setDescription($faker->text());
            //$product->setSlug($this->slugger->slug($product->getName())->lower()); //si utilisation de fonction slug);
            $product->setPrice($faker->numberBetween(1000, 100000)); // remplace les espaces par rien dans le zipcode(postcode)
            $product->setStock($faker->numberBetween(0, 12));
            //$product->setCategories($category);

            $category = $this->getReference('cat-' .rand(1, 6)); //gestion du cas particulier de liaison pour le faker de Products/Categories
            $product->setCategories($category); //gestion du cas particulier de liaison pour le faker de Products/Categories

            $this->setReference('prod-' .$prdct, $product); //gestion du cas particulier de liaison pour le faker de Products/Images

            $manager->persist($product);


            //dump($product); //vu des donnees dans la console


        }

        $manager->flush();

    }

}
