<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
//Ici Il y a la route pour ma page Home avec sa fonction et de dans mon paramètre pour récupérer les articles récents dans "Information Récentes".
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepo, CategoryRepository $categoryRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articleRepo->findAll(),
            'categories' => $categoryRepo->findAll()

        ]);
    }
}
