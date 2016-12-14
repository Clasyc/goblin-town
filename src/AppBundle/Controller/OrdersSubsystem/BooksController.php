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
     * @Route("/reader/reserve-book/{id}", name="orders_create-reservation-form")
     */
    public function createReservationFormAction($id)
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($id);

        if ($this->isBookRelatedWithReader($this->getReaderId(), $book->getId()))
        {
            $this->addFlash(
                'error',
                'Jau esate užsisakę arba rezervavę šią knygą.'
            );
            return $this->redirectToRoute("readers_books-list");
        }
        else
        {
            $queue = $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('AppBundle:Reservations')
                ->countQueueNumber($book->getId());

            $csrfToken = $this->has('security.csrf.token_manager')
                ? $this->get('security.csrf.token_manager')->refreshToken('reservation')->getValue()
                : null;

            return $this->render('default/ROLE_reader/book-reservation.html.twig', array('book' => $book, 'queue' => $queue[0][1], 'csrf_token' => $csrfToken));
        }
    }


    private function isBookRelatedWithReader($readerId, $bookId)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $orderValue = $em->getRepository("AppBundle:Readers")->isBookAlreadyOrderedByReader($readerId, $bookId);
        $reservationValue = $em->getRepository("AppBundle:Readers")->isBookAlreadyReservedByReader($readerId, $bookId);

        if ($orderValue || $reservationValue)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function getReaderId()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}