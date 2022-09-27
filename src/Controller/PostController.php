<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Post;
use DateTimeImmutable;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        // On récupere le repository et on utilise la méthode findAll
        $posts  = $doctrine->getRepository(Post::class)->findAll();

        // dd($posts);

        return $this->render('post/list.html.twig',[
            'posts' => $posts
        ]);
    }

    /**
     * Traite le formulaire d'ajout d'un post
     * 
     * @Route("/article/ajouter", name="post_addValid", methods={"POST"})
     */
    public function addValid(ManagerRegistry $doctrine, Request $request): Response
    {
        // Récupération de l'entityManager
        $entityManager = $doctrine->getManager();

        // Nouvelle instance de post appel du constructeur
        $post = new Post();
        // Je récupère mon instance de l'auteur passé dans le formulaire
        $author = $entityManager->getRepository(Author::class)->find($request->get('author'));
        // on set nos attributs

        $post->setTitle($request->get('title'));
        $post->setBody($request->get('body'));
        $post->setPublishedAt(new DateTimeImmutable($request->get('publishedAt')));
        $post->setImage($request->get('image'));
        $post->setAuthor($author);

        // 2 lignes de codes
        $entityManager->persist($post);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Article bien ajouté'
        );
        
        return $this->redirectToRoute('post_list');
    }

     /**
     * Affichage le formulaire d'ajout d'un article
     * 
     * @Route("/article/ajouter", name="post_add", methods={"GET"})
     */
    public function add(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        // On récupère les auteurs
        $authors = $entityManager->getRepository(Author::class)->findall();
    

        return $this->render('post/add.html.twig',[
            'authors' => $authors
        ]);
    }

    /**
     * Traite le formulaire de modification d'un post
     * 
     * @Route("/article/modifier/{id}", name="post_editValid", methods={"GET"})
     */
    public function editValid(ManagerRegistry $doctrine,Post $post): Response
    {
        // Récupération de l'entityManager
        $entityManager = $doctrine->getManager();
        // On set les params à modifier
        $post->setTitle('mon article modifié');
        $post->setUpdatedAt(new DateTimeImmutable());

        // Pas besoin de persist pour une modif
        $entityManager->flush();

        return $this->redirectToRoute('post_list');
    }

    /**
     * Affichage d'un article par son id
     * 
     * @Route("/article/{id}", name="post_show")
     */
    public function show(Post $post): Response
    {
        // Méthode 1 
        // $post = $doctrine->getRepository(Post::class)->find($id);
        return $this->render('post/show.html.twig',[
            "post" => $post
        ]);
    }

      /**
     * Suppression d'un article par son id
     * 
     * @Route("/article/supprimer/{id}", name="post_delete")
     */
    public function delete(Post $post, ManagerRegistry $doctrine): Response
    {
        // On récupère le manager
        $entityManager = $doctrine->getManager();

        // Préviens doctrine qu'on veut supprimer un objet
        $entityManager->remove($post);

        // Execute le sql
        $entityManager->flush();

        return $this->redirectToRoute('post_list');
    }

}
