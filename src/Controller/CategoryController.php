<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    //Paramètre pour retourner/récupérer une catégorie, mais si la catégorie est null (?), je return à la page home avec mon if s'il n'existe pas (!).

    #[Route('/categorie/{slug}', name: 'category_see')]
    public function see(?Category $category): Response
    {

        if (!$category) {
            return $this->redirectToRoute('app_home');
        }
        return $this->render('category/see.html.twig', [
            'category' => $category
        ]);
    }
}
