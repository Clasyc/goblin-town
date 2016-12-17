<?php

namespace AppBundle\Controller\ReadersSubsystem;

use AppBundle\Entity\Wishlists;
use AppBundle\Form\Type\ReaderRegistration_NoFosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class BooksHistoryController extends Controller
{
    /**
     * @Route("/reader/history/{page}", name="readers_history-list")
     */
    public function readersHistoryAction($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        $orders = $em->getRepository("AppBundle:Orders")->findOrdersByReader($reader->getPersonalId(), true);


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_reader/history.html.twig', [
            "pagination" => $pagination
        ]);
    }

}
