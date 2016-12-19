<?php

namespace AppBundle\Controller\BooksSystem;

use AppBundle\AppBundle;
use AppBundle\Entity\Books;
use AppBundle\Form\Type\AuthorType;
use AppBundle\Form\Type\BooksType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BooksSearchController extends Controller
{

    /**
    * @Route("/booksAdmin/books-list/", name="book_admins-search")
    */
    public function searchAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $defaultData = array('message' => 'Type your message here');
        $searchForm = $this->createFormBuilder($defaultData)
            ->add('searchTerm', TextType::class, array(
                'label' => FALSE,
                'attr' => array('style' => 'width: 300px')
            ))
            ->add('Ieskoti', SubmitType::class)
            ->getForm();
        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $searchTerm = $searchForm['searchTerm']->getData();


            $books = $em->getRepository("AppBundle:Books")->findSearchedBooks(true, $searchTerm);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $books, /* query NOT result */
                $page/*page number*/,
                10/*limit per page*/
            );

            return $this->render('default/ROLE_booksAdmin/search-list.html.twig', [
                "pagination" => $pagination
            ]);

        }
        else{
            $errors = $searchForm->getErrors(true);
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $request->getSession()->getFlashBag()->add(
                        'error',
                        $error->getMessage()
                    );
                    $isError = true;
                }
            }
        }

        $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );


        return $this->render('default/ROLE_booksAdmin/index.html.twig', [
            "searchForm" => $searchForm->createView(),
            "pagination" => $pagination
        ]);
    }

}
