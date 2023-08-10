<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
//use symfony\component\String\Slugger\SluggerInterface;

class CategoriesFixtures extends Fixture
{
    private $counter = 1;

    //public function __construct(private SluggerInterface $slugger){} //si utilisation de fonction slug

    public function load(ObjectManager $manager): void
    {
        /*//si il y a et se trouve etre un parent
        $parent = new Categories();
        $parent->setName('Technology');
        //$parent->setSlug('technology'); //si utilisation des slug
            //$parent->setSlug($this->slugger->slug($category->getName())->lower()); //si utilisation de fonction slug
        $manager->persist($parent);

        //si il n'a pas de parents
        $category = new Categories();
        $category->setName('Computer');
        //$category->setSlug('computer'); //si utilisation des slug
            //$parent->setSlug($this->slugger->slug($category->getName())->lower()); //si utilisation de fonction slug
        $category->setParent($parent); //si il a un parent sinon inutile
        $manager->persist($category);

        $category = new Categories();
        $category->setName('Accessory');
        //$category->setSlug('accessory'); //si utilisation des slug
            //$parent->setSlug($this->slugger->slug($category->getName())->lower()); //si utilisation de fonction slug
        $category->setParent($parent); //si il a un parent sinon inutile
        $manager->persist($category);*/

        //ou methode simplifiee

        $parent = $this->createCategory('Computer', null, $manager); //ou en parametres nommes (name: 'Technologie', manager: $manager) 
        
        $this->createCategory('Desktop', $parent, $manager);
        $this->createCategory('Laptop', $parent, $manager);

        $parent = $this->createCategory('Accessory', null, $manager); //ou en parametres nommes (name: 'Technologie', manager: $manager) 
        
        $this->createCategory('Screen', $parent, $manager);
        $this->createCategory('Keyboard', $parent, $manager);
        $this->createCategory('Mousse', $parent, $manager);
        //$this->createCategory('Webcam', $parent, $manager);
        //$this->createCategory('Usb Key', $parent, $manager);        //$this->createCategory('Mousse', $parent, $manager);



        $manager->flush();
    }
    
    public function createCategory(string $name, Categories $parent = null, ObjectManager $manager){
        $category = new Categories();
        $category->setName($name);
            //$parent->setSlug($this->slugger->slug($category->getName())->lower()); //si utilisation de fonction slug
        $category->setParent($parent); //si il a un parent sinon inutile
        $manager->persist($category);

        $this->addReference('cat-' .$this->counter, $category); //gestion du cas particulier de liaison pour le faker de Products/Categories
        $this->counter++; //gestion du cas particulier de liaison pour le faker de Products/Categories

        return $category;
    }
}
