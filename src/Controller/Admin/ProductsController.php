<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductsFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/admin/products', name: 'admin_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/products/index.html.twig', [
            'controller_name' => 'Products',
        ]);
    }
    
    #[Route('/add', name: 'add')]
    //on va devoir chercher a recuperer la requete cree et gererle stockage en base de donnees pour pouvoir traiter notre formulaire
    public function add(Request $request, EntityManagerInterface $em): Response
    {
        //on verifie l'autorisation a l'utilisateur d'ajouter avec le voter
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        //on cree notre nouveau produit
        $product = new Products();

        //on cree notre nouveau fornulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //on traite la requete du formulaire
        $productForm->handleRequest($request);

        //dd($productForm);

        // on verifie la soumission du formulaire et sa validite
        if ($productForm->isSubmitted() && $productForm->isValid()){
            //on genere le slug
            //$slug = $slugger->($product->getName()); //si on utilise le slug

            //dd($slug);

            //on convertit le prix
            $price = $product->getPrice() * 100;
            $product->setPrice($price);

            //dd($price);

            //on fixe dans la base de donnees
            $em->persist($product);
            $em->flush();

            //on informe de la validite de l'action
            //$this->addFlash('success', 'Add Success !'); //a utiliser avec la creation d'un fichier _flashmsg.html.twig

            //et on redirige vers la page que l'on souhaite
            return $this->redirectToRoute("admin_products_index");
        }

        return $this->render('admin/products/add.html.twig', [
            'controller_name' => 'Add Product',
            //on recupere notre formulaire
            'productForm'     =>  $productForm->createView(),
        ]);

        //ou //return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
    }

    #[Route('/edit/{name}', name: 'edit')]
    public function edit(Products $product, Request $request, EntityManagerInterface $em): Response
    {
        //on verifie l'autorisation a l'utilisateur d'editer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_EDIT', $product);

        //on convertit le prix recupere pour prevenir de la sur-conversion lors de la modification
        $price = $product->getPrice() / 100;
        $product->setPrice($price);

        //on cree notre nouveau fornulaire
        $productForm = $this->createForm(ProductsFormType::class, $product);

        //on traite la requete du formulaire
        $productForm->handleRequest($request);

        //dd($productForm);

        // on verifie la soumission du formulaire et sa validite
        if ($productForm->isSubmitted() && $productForm->isValid()){
            //on genere le slug
            //$slug = $slugger->($product->getName()); //si on utilise le slug

            //dd($slug);

            //on convertit le prix
            $price = $product->getPrice() * 100;
            $product->setPrice($price);

            //dd($price);

            //on fixe dans la base de donnees
            $em->persist($product);
            $em->flush();

            //on informe de la validite de l'action
            //$this->addFlash('success', 'Edit Success !'); //a utiliser avec la creation d'un fichier _flashmsg.html.twig

            //et on redirige vers la page que l'on souhaite
            return $this->redirectToRoute("admin_products_index");
        }
        return $this->render('admin/products/edit.html.twig', [
            'controller_name' => 'Edit Product',
            //on recupere notre formulaire
            'productForm'     =>  $productForm->createView(),
        ]);

        //ou //return $this->renderForm('admin/products/add.html.twig', compact('productForm'));
    } 

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Products $product): Response
    {
        //on verifie l'autorisation a l'utilisateur de supprimer avec le voter
        $this->denyAccessUnlessGranted('PRODUCT_DELETE', $product);
        return $this->render('admin/products/index.html.twig', [
            'controller_name' => 'Delete',
        ]);
    }
}
