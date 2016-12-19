<?php

namespace AppBundle\Controller\OrdersSubsystem;

use AppBundle\Entity\Depts;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DebtsController extends Controller
{
    /**
     * @Route("/employee/debt/{id}", name="orders_employee-get-debt")
     */
    public function getDebtFormAction($id)
    {
        $debt = $this->getDoctrine()
            ->getRepository('AppBundle:Depts')
            ->find($id);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->refreshToken('debt')->getValue()
            : null;

        if (empty($debt))
        {
            $this->addFlash(
                'error',
                'Skola nerasta.'
            );
            return $this->redirectToRoute('orders_employee-orders-list');
        }

        return $this->render('default/ROLE_employee/debt-info.html.twig', ['debt' => $debt, 'csrf_token' => $csrfToken]);
    }

    /**
     * @Route("/employee/debts/payment", name="orders_employee-debt-payment")
     */
    public function payDebtAction(Request $request)
    {
        $debt = $this->getDoctrine()
            ->getRepository('AppBundle:Depts')
            ->find($request->request->get('id'));

        if ($request->isMethod('POST') && $this->isCsrfTokenValid('debt', $request->request->get('_csrf_token')))
        {
            $debt->setStatus(Depts::PAID);
            $em = $this->getDoctrine()->getManager();
            $em->persist($debt);
            $em->flush();

            $this->addFlash(
                'info',
                'Skola apmokėta.'
            );
        }
        else
        {
            $this->addFlash(
                'error',
                'Įvyko klaida.'
            );
        }

        return $this->redirectToRoute("orders_employee-get-debt", array('id' => $debt->getId()));
    }
}