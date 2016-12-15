<?php

namespace AppBundle\Controller\OrdersSubsystem;

use AppBundle\Entity\Orders;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends Controller
{
    /**
     * @Route("/reader/order-book", name="orders_order-book")
     */
    public function orderBookAction(Request $request)
    {
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($request->query->get('id'));

        $order = new Orders();

        $form = $this->createFormBuilder($order)->getForm();

        if ($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            if ($form->isSubmitted() && $this->isCsrfTokenValid('order', $request->request->get('_csrf_token')))
            {
                $takeConditions = $request->request->get('order-book-condition');
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
                        'Knyga sėkmingai užsakyta.'
                    );
                }
                else
                {
                    $this->addFlash(
                        'error',
                        'Knyga buvo užsakyta kito skaitytojo.'
                    );
                }
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
     * @Route("/employee/orders-list/{page}", name="orders_employee-orders-list")
     */
    public function getAllOrdersList($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $orders = $em->getRepository("AppBundle:Orders")->findAllOrders(true);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $orders, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_employee/index.html.twig', [
            "pagination" => $pagination
        ]);
    }

    private function getReaderId()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}