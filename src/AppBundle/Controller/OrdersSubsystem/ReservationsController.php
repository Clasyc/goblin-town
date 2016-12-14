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

    private function getReaderId()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}