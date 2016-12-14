<?php

namespace AppBundle\Controller\ReadersSubsystem;

use AppBundle\Form\Type\ReaderRegistration_NoFosType;
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
        $items_per_page = 25;

        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);

        $wishlist = $em->getRepository("AppBundle:Books")->findBooksInWishlist($this->getReaderId(), true);


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            $items_per_page/*limit per page*/
        );
        $wishlist_books = $paginator->paginate(
            $wishlist, /* query NOT result */
            $page/*page number*/,
            $items_per_page/*limit per page*/
        );

        foreach($pagination as $book){
            foreach($wishlist_books as $w_book){
                if($book->getId() == $w_book->getId()){
                    $book->setMarked(true);
                }
            }
        }

        return $this->render('default/ROLE_reader/index.html.twig', [
            "pagination" => $pagination
        ]);
    }
    /**
     * @Route("/reader/profile", name="readers_edit-profile")
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        if(empty($reader))
            return $this->redirectToRoute("readers_books-list");

        $form = $this->createForm(ReaderRegistration_NoFosType::class, $reader, array(
            'method' => 'POST',
            'validation_groups' => array('Reader'),
            'attr' => array('class' => 'col-sm-10 col-sm-offset-1')
        ));

        $form->handleRequest($request);
        $reader->getFosuser()->setEmail($reader->getEmail());

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();

            $em->persist($reader);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Profilis sėkmingai redaguotas!'
            );
            return $this->redirectToRoute('readers_books-list');
        }

        return $this->render('default/ROLE_reader/profile-edit.html.twig', [
            "reader" => $reader,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/readers-admin/readers-list/{page}", name="readers-admin_readers-list")
     */
    public function readersListAction($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Readers")->findAllReaders(true);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_readers_admin/index.html.twig', [
            "pagination" => $pagination
        ]);
    }

    /**
     * @Route("/readers-admin/reader/edit/{readerId}", name="readers-admin_reader-edit")
     */
    public function editReaderAction(Request $request, $readerId = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        if($readerId === null || !ctype_digit($readerId))
            return $this->redirectToRoute("readers-admin_readers-list");

        $reader = $em->getRepository("AppBundle:Readers")->findReader($readerId);


        if(empty($reader))
            return $this->redirectToRoute("readers-admin_readers-list");


        $form = $this->createForm(ReaderRegistration_NoFosType::class, $reader, array(
            'method' => 'POST',
            'validation_groups' => array('Reader'),
            'attr' => array('class' => 'col-sm-10 col-sm-offset-1')
        ));

        $form->handleRequest($request);
        $reader->getFosuser()->setEmail($reader->getEmail());

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();

            $em->persist($reader);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Skaitytojas '.$reader->getName()." ".$reader->getLastName()." sėkmingai redaguotas!"
            );
            return $this->redirectToRoute('readers-admin_readers-list');
        }

        return $this->render('default/ROLE_readers_admin/reader-edit.html.twig', [
            "reader" => $reader,
            "form" => $form->createView()
        ]);
    }

    private function getReaderId(){
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }

}
