<?php

namespace App\Controller;

use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/{name}', name: 'list')] //remplacer '/{name}' par '/{slug}' si utilistaion des slug
    public function list(Categories $category): Response // la methode ici nous renvoie une reponse par injection en paramettre du repository nous permettant de recuperer nos donnees
    {

        $products = $category->getProducts(); //pour aller chercher les produits de la categorie concernee
        //dd($category); //->getNameColumnofTable; 
        //dumpdata & die de notre category, et si l'on veut, passer une methode de notre entity pour cibler le resultat de notre recherche
        return $this->render('categories/list.html.twig', [
            'controller_name' => 'List of',
            'category'         =>  $category,
            'products'          =>   $products,
        ]);

        //return $this->render('categories/list.html.twig', compact('category', 'products')); // ou cette version compact, en prenant soin de remplacer 'controller_name' dans list.html.twig par un h1 personnalise
    }
}
