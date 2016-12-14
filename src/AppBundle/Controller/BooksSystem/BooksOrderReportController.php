<?php

namespace AppBundle\Controller\BooksSystem;

use AppBundle\AppBundle;
use AppBundle\Entity\Books;
use AppBundle\Form\Type\AuthorType;
use AppBundle\Form\Type\BooksType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\HttpFoundation\Request;

class BooksOrderReportController extends Controller
{
    /**
     * @Route("/booksAdmin/books-report/{page}", name="book_admins_books-report")
     */
    public function orderedBooksAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_booksAdmin/index.html.twig', [
            "pagination" => $pagination
        ]);

    }


}
