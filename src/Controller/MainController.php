<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main')] // cette Route est conposee d'un chemin ou url que nous remplacerons par '/' a la place du '/main' d'origine et d'un nom pour identifier la route ou redirection souhaitee
    public function index(CategoriesRepository $categoriesRepository): Response // la methode ici nous renvoie une reponse par injection en paramettre du repository nous permettant d'interroger notre base de donnees
    {
        //$categories = $categoriesRepository->findBy(); //methode de transmission options1 (probleme)
        return $this->render('main/index.html.twig', [
            'categories' => $categoriesRepository->findBy([], //methode de transmission options2
            ['categoryOrder' => 'asc']) //range par ordre coroissant
        ]); // et nous retourne le fichier du dossier, voulu, etabli au prealable
    }
}
