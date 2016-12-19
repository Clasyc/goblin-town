<?php

namespace AppBundle\Controller\OrdersSubsystem;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        if (empty($debt))
        {
            $this->addFlash(
                'error',
                'Skola nerasta.'
            );
            return $this->redirectToRoute('orders_employee-orders-list');
        }

        return $this->render('default/ROLE_employee/debt-info.html.twig', ['debt' => $debt]);
    }
}