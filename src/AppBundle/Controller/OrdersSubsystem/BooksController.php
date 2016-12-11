<?php

namespace AppBundle\Controller\OrdersSubsystem;

use AppBundle\Entity\Orders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class BooksController extends Controller
{
    /**
     * @Route("/reader/order-book/{id}", name="orders_order-book")
     */
    public function orderBookAction(Request $request, $id)
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($id);

        $order = new Orders();

        $form = $this->createFormBuilder($order)->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $takeConditions = $request->request->get("order-book-condition");
            $takeDate = (new \DateTime());
            $agreedReturnDate = date_add(\DateTime::createFromFormat('Y-m-d', $takeDate->format('Y-m-d')),
                                        date_interval_create_from_date_string($takeConditions));
            $status = Orders::WAITING;
            $debtRatePerDay = 0.03;
            $reader = $this->getDoctrine()
                    ->getRepository('AppBundle:Readers')
                    ->find($this->getReaderId());

            $order->setTakeDate($takeDate);
            $order->setAgreedReturnDate($agreedReturnDate);
            $order->setTakeConditions($takeConditions);
            $order->setStatus($status);
            $order->setDeptRatePerDay($debtRatePerDay);
            $order->setFkBook($book);
            $order->setFkReader($reader);

            if ($book->getOrdered() != true)
            {
                $book->setOrdered(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->persist($book);
                $em->flush();

                $this->addFlash(
                    'success',
                    'Knyga užsakyta!'
                );
            }
            else
            {
                $this->addFlash(
                    'error',
                    'Knyga buvo užsakyta kito skaitytojo!'
                );
            }
        }

        if ($book->getOrdered() != true)
        {
            return $this->render('default/ROLE_reader/book-order.html.twig', array('book' => $book, 'form' => $form->createView()));
        }
        else
        {
            $this->addFlash(
                'error',
                'Knyga, kurią bandota pasiekti yra užsakyta!'
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

    private function getReaderId(){
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}