<?php

namespace AppBundle\Controller\OrdersSubsystem;

use AppBundle\Entity\Reservations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationsController extends Controller
{
    /**
     * @Route("/reader/reserve-book", name="orders_reserve-book")
     */
    public function reserveBookAction(Request $request)
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($request->query->get('id'));

        $reservation = new Reservations();

        $form = $this->createFormBuilder($reservation)->getForm();

        if ($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $this->isCsrfTokenValid('reservation', $request->request->get('_csrf_token')))
            {
                $date = (new \DateTime());
                $queue = $this->getDoctrine()
                    ->getRepository('AppBundle:Reservations')
                    ->countQueueNumber($book->getId());
                $queueMoved = (new \DateTime());
                $status = Reservations::RESERVED;
                $reader = $this->getDoctrine()
                    ->getRepository('AppBundle:Readers')
                    ->find($this->getReaderId());

                $reservation->setDate($date);
                $reservation->setQueue($queue[0][1] + 1);
                $reservation->setQueueMoved($queueMoved);
                $reservation->setStatus($status);
                $reservation->setFkReader($reader);
                $reservation->setFkBook($book);

                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Knyga sėkmingai rezervuota.'
                );
            }
            else
            {
                $this->addFlash(
                    'error',
                    'Įvyko klaida.'
                );
            }
        }
        return $this->redirectToRoute("readers_books-list");
    }

    /**
     * @Route("/reader/cancel-reservation", name="orders_cancel-reservation")
     */
    public function cancelBookReservationAction(Request $request)
    {
        $reservation = $this->getDoctrine()
            ->getRepository('AppBundle:Reservations')
            ->find($request->request->get('id'));

        if ($request->isMethod('POST'))
        {
            $queue = $reservation->getQueue();
            $reservation->setStatus(Reservations::CANCELLED);
            $reservation->setQueue(-1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();

            $this->getDoctrine()
                ->getEntityManager()
                ->getRepository('AppBundle:Reservations')
                ->refreshReservationsAfterCancel($reservation->getFkBook(), new \DateTime(), $queue);

            $this->checkIfNoReservationQueue($reservation->getFkBook());

            $this->addFlash(
                'info',
                'Rezervacija panaikinta.'
            );
        }
        else
        {
            $this->addFlash(
                'error',
                'Įvyko klaida.'
            );
        }
        return $this->redirectToRoute("orders_reader-reservations-list");
    }

    /**
     * @Route("/reader/reservations-list/{page}", name="orders_reader-reservations-list")
     */
    public function getReadersReservationsAction($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $reservations = $em->getRepository("AppBundle:Reservations")->findReadersReservations($this->getReaderId(), true);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reservations, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_reader/reservations-list.html.twig', [
            "pagination" => $pagination
        ]);
    }

    private function checkIfNoReservationQueue($bookId)
    {
        $queue = $this->getDoctrine()
            ->getEntityManager()
            ->getRepository('AppBundle:Reservations')->countQueueNumber($bookId);

        if ($queue[0][1] == 0)
        {
            $book = $this->getDoctrine()
                ->getRepository('AppBundle:Books')
                ->find($bookId);

            $book->setOrdered(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();
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