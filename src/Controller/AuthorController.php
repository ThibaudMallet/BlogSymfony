<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    /**
     * @Route("/auteur", name="author_list")
     */
    public function list(ManagerRegistry $doctrine): Response
    {
        $authors = $doctrine->getRepository(Author::class)->findAll();

        return $this->render('author/list.html.twig',[
            'authors' => $authors
        ]);
    }

    /**
    * Traite le formulaire d'ajout d'un auteur
    * 
    * @Route("/auteur/ajouter", name="author_addValid", methods={"POST"})
    */
    public function addValid(ManagerRegistry $doctrine, Request $request): Response
    {
        // Récupération de l'entityManager
        $entityManager = $doctrine->getManager();

        // Nouvelle instance d'auteur appel du constructeur
        $author = new Author();
        // on set nos attributs

        $author->setFirstname($request->get('firstname'));
        $author->setLastname($request->get('lastname'));

        // 2 lignes de codes
        $entityManager->persist($author);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Auteur bien ajouté'
        );
        
        return $this->redirectToRoute('author_list');
    }

    /**
    * Affichage du formulaire d'ajout d'un auteur
    * 
    * @Route("/auteur/ajouter", name="author_add", methods={"GET"})
    */
    public function add(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();    

        return $this->render('author/add.html.twig');
    }
}
