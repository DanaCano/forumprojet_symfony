<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    #[Route('/ajax/comments', name: 'comment_add')]
    public function add(Request $request, ArticleRepository $articleRepo, CommentRepository $commentRepo, EntityManagerInterface $em, UserRepository $userRepo): Response
    {
        //Ici c'est parce que je vais utiliser ma methode Post.
        $commentData = $request->request->all('comment');

        if(!$this->isCsrfTokenValid('comment-add', $commentData['_token'])) {
            return $this->json([
                'code' => 'INVALID_CSRF_TOKEN'
            ], Response::HTTP_BAD_REQUEST);
        }

        //Si jamais tout est ok ou bon, je vais récupérer l'article.
        $article = $articleRepo->findOneBy(['id' => $commentData['article']]);

        //Si jamais je ne trouve pas l'article je vais retourner une reponse json.
        if (!$article) {
            return $this->json([
                'code' => 'ARTICLE_NOT_FOUND',
            ], Response::HTTP_BAD_REQUEST);
        }

        //Si jamais tout est bon je vais pouvoir creer mon objet comment.
        $comment = new Comment($article);
        $comment->setContent($commentData['content']);
        $comment->setUser($userRepo->findOneBy(['id' => 1]));
        $comment->setCreatedAt(new \DateTime());

        //Ici je vais persister mon objet comment pour appliquer les modifs et ensuite je flush pour envoyer tout ça dans ma BDD.
        $em->persist($comment);
        $em->flush();

        //en suite le rendu de la page comment pour envoyer les infos vers son index.html.twig; en passant en parametre mon commentaire.
        $html = $this->renderView('comment/index.html.twig', [
            'comment' => $comment
            ]);

        //et je vais retourner de json, c'est àa dire un code COMMENT_ADDED_SUCCESSFULLY (un message) et aussi avec le nom de commentaires.
        // Je passe en critères contre le nom des comentaires qui sont associés à cet article.
        return $this->json([
          'code' => 'COMMENT_ADDED_SUCCESSFULLY',
            'message' => $html,
            'numberOfComment' => $commentRepo->count(['article' => $article])
        ]);
    }
}
