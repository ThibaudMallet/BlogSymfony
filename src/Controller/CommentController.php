<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/add", name="comment_addValid", methods={"POST"})
     */
    public function addValid(ManagerRegistry $doctrine, Request $request): Response
    {
        // on recupere le manager
        $entityManager = $doctrine->getManager();

        // Création d'un nouveau commentaire
        $comment = new Comment();
        // Récupération du post
        $post = $entityManager->getRepository(Post::class)->find($request->get('post'));

        $comment->setUsername($request->get('username'));
        $comment->setBody($request->get('body'));
        $comment->setPost($post);

        $entityManager->persist($comment);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Commentaire bien ajouté'
        );
        // dd($request->headers);
        // TODO TROUVER LA SOLUCE
        // Methode 1 pour rediriger vers l'article qui va bien
        // return $this->redirectToRoute('post_show', [
        //     'id' => $post->getId()
        // ]);
        // Méthode 2 Pour rediriger vers la page depuis laquel on vient
        return $this->redirect($request->headers->get('referer'));
    }
}
