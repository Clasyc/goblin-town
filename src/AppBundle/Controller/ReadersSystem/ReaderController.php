<?php

namespace AppBundle\Controller\ReadersSystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReaderController extends Controller
{

    /**
     * @Route("/reader/books-list/{page}", name="readers_books-list")
     */
    public function booksListAction($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_reader/index.html.twig', [
            "pagination" => $pagination
        ]);
    }
}
