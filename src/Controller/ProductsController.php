<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'Our Products',
        ]);
    }

    #[Route('/{name}', name: 'details')] //remplacer '/{name}' par '/{slug}' si utilistaion des slug
    public function details(Products $product): Response
    {
        //dd($product); //->getNameColumnofTable; 
        //dumpdata & die de notre product, et si l'on veut, passer une methode de notre entity pour cibler le resultat de notre recherche
        return $this->render('products/details.html.twig', [
            'controller_name' => 'Details of',
            'product'         =>  $product,
        ]);

        //return $this->render('products/details.html.twig', compact('product')); // ou cette version compact, en prenant soin de remplacer 'controller_name' dans details.html.twig par un h1 personnalise
    }
}
