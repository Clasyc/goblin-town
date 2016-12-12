<?php

namespace AppBundle\Controller\OrdersSubsystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BooksController extends Controller
{
    /**
     * @Route("/reader/order-book/{id}", name="orders_create-order-form")
     */
    public function createOrderFormAction($id)
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($id);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->refreshToken('order')->getValue()
            : null;

        if ($book->getOrdered() != true)
        {
            return $this->render('default/ROLE_reader/book-order.html.twig', array('book' => $book, 'csrf_token' => $csrfToken));
        }
        else
        {
            $this->addFlash(
                'error',
                'Knyga, kurią bandote pasiekti jau yra užsakyta.'
            );
            return $this->redirectToRoute("readers_books-list");
        }
    }

    /**
     * @Route("/reader/reserve-book/{id}", name="orders_reserve-book")
     */
    public function reserveBookAction($id)
    {
        return $this->render('default/ROLE_reader/book-reservation.html.twig', array('id' => $id));
    }
}