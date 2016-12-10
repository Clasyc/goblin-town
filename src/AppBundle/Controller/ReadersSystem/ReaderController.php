<?php

namespace AppBundle\Controller\ReadersSystem;

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
    /**
     * @Route("/reader/profile", name="readers_edit-profile")
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

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

        return $this->render('default/ROLE_reader/profile-edit.html.twig', [
            "reader" => $reader,
            "form" => $form->createView()
        ]);
    }
}
