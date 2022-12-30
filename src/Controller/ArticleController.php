<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    //Paramètre pour retourner un article, mais si l'article est null (?), je return à la page home avec mon if s'il n'existe pas (!).
    #[Route('/article/{slug}', name: 'article_see')]
    public function see(?Article $article): Response
    {
        if (!$article) {
            return $this->redirectToRoute('app_home');
        }

        //Je passe une valeur dans $data (pour les articles avec des commentaires) voir mon constructeur dans mon entity Comment.php .
        $comment = new Comment($article);

        //Variable de mon formulaire
        $commentForm= $this->createForm(CommentType::class, $comment);

        return $this->render('article/see.html.twig', [
            'article' => $article,
            'commentForm' => $commentForm
        ]);
    }
}
