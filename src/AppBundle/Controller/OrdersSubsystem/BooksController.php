<?php

namespace AppBundle\Controller\OrdersSubsystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BooksController extends Controller
{
    /**
     * @Route("/reader/order-book/{id}", name="orders_order-book")
     */
    public function orderBookAction($id)
    {
        return $this->render('default/ROLE_reader/book-order.html.twig', array('id' => $id));
    }

    /**
     * @Route("/reader/reserve-book/{id}", name="orders_reserve-book")
     */
    public function reserveBookAction($id)
    {
        return $this->render('default/ROLE_reader/book-reservation.html.twig', array('id' => $id));
    }
}