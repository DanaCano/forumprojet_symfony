<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/page/{slug}', name: 'page_see')]
    public function see(): Response
    {
        return $this->render('page/see.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
