<?php

namespace AppBundle\Controller\ReadersAdminSystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\ReaderRegistration_NoFosType;

class ReadersAdminController extends Controller
{

    /**
     * @Route("/readers-admin/readers-list/{page}", name="readers-admin_readers-list")
     */
    public function booksListAction($page = 1)
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
     * @Route("/readers-admin/reader-edit/{readerId}", name="readers-admin_reader-edit")
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
}
