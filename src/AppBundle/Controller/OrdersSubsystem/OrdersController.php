<?php

namespace AppBundle\Controller\OrdersSubsystem;

use AppBundle\Entity\Depts;
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
     * @Route("/employee/orders-list/{page}", name="orders_employee-orders-list", requirements={"page": "\d+"})
     */
    public function getAllOrdersListAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if (!$request->isMethod('POST'))
        {
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
       else
       {
           $searchString = $request->request->get('search-string');
           $filteredOrders = $em->getRepository("AppBundle:Orders")->findOrdersByBookReader($searchString, true);

           $paginator  = $this->get('knp_paginator');
           $pagination = $paginator->paginate(
               $filteredOrders, /* query NOT result */
               $page/*page number*/,
               10/*limit per page*/
           );

           return $this->render('default/ROLE_employee/index.html.twig', [
               "pagination" => $pagination
           ]);
       }
    }

    /**
     * @Route("/employee/orders-list/process", name="orders_employee-process-order")
     */
    public function processOrderAction(Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->find($request->request->get('id'));

        if ($request->isMethod('POST'))
        {
            $status = $request->request->get('status');

            if ($status == Orders::BORROWED)
            {
                $order->setStatus($status);

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                $this->addFlash(
                    'info',
                    'Užsakymas sėkmingai patvirtintas.'
                );
            }
            else if ($status == Orders::REJECTED)
            {
                $book = $this->getDoctrine()
                    ->getRepository('AppBundle:Books')
                    ->find($request->request->get('book'));
                $order->setStatus($status);
                $book->setOrdered(false);

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->persist($book);
                $em->flush();

                $this->addFlash(
                    'info',
                    'Užsakymas atmestas.'
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

        return $this->redirectToRoute("orders_employee-orders-list");
    }

    /**
     * @Route("/employee/order/{id}", name="orders_employee-get-order")
     */
    public function getOrderFormAction($id)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->find($id);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->refreshToken('order')->getValue()
            : null;

        return $this->render('default/ROLE_employee/order-info.html.twig', array('order' => $order, 'csrf_token' => $csrfToken));
    }

    /**
     * @Route("/employee/accept-book-return", name="orders_employee-return-book")
     */
    public function acceptBookReturnAction(Request $request)
    {
        $order = $this->getDoctrine()
            ->getRepository('AppBundle:Orders')
            ->find($request->query->get('id'));
        $book = $this->getDoctrine()
            ->getRepository('AppBundle:Books')
            ->find($order->getFkBook());
        $actualReturnDate = (new \DateTime());

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('order', $request->request->get('_csrf_token')))
        {
            $em = $this->getDoctrine()->getManager();

            if ($actualReturnDate > $order->getAgreedReturnDate())
            {
                $dateDifference = $actualReturnDate->diff($order->getAgreedReturnDate())->format("%a");
                $debt = new Depts();
                $debt->setStatus(Depts::UNPAID);
                $debt->setDescription("Skola už pavėluotai grąžintą knygą.");
                $debt->setFkOrder($order);
                $debt->setPaymentDate($actualReturnDate);
                $debt->setAmount($dateDifference * $order->getDeptRatePerDay());

                $order->setStatus(Orders::DEBT);
                $em->persist($debt);

                $this->addFlash(
                    'info',
                    'Knyga grąžinta. Sudaryta skola už vėlavimą.'
                );
            }
            else
            {
                $this->addFlash(
                    'info',
                    'Knyga grąžinta laiku.'
                );
                $order->setStatus(Orders::RETURNED);
            }

            $order->setActualReturnDate($actualReturnDate);
            $book->setOrdered(false);
            $this->getDoctrine()
                ->getRepository('AppBundle:Reservations')
                ->refreshReservations($book->getId());

            $em->persist($order);
            $em->persist($book);
            $em->flush();
        }
        else
        {
            $this->addFlash(
                'error',
                'Įvyko klaida.'
            );
        }
        return $this->redirectToRoute("orders_employee-orders-list");
    }

    private function getReaderId()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}