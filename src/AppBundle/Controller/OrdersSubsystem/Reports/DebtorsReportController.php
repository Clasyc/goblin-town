<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DebtorsReportController extends Controller
{
    /**
     * @Route("/employee/report/debtors", name="orders_employee-debtors-report")
     */
    public function getDebtorsReportWindowAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if ($request->isMethod('POST'))
        {
            $debts = $em->getRepository('AppBundle:Depts')->findAllUnpaidDebtsForReport();
            $debtsSum = $em->getRepository('AppBundle:Depts')->findAllUnpaidDebtsSumForReport();

            if (count($debts) < 1)
            {
                $this->addFlash(
                    'error',
                    'Neapmokėtų skolų nėra.'
                );
            }
            else
            {
                return $this->render('default/ROLE_employee/debtors-report.html.twig', [
                    "debts" => $debts,
                    "debtsSum" => $debtsSum
                ]);
            }
        }

        return $this->render('default/ROLE_employee/debtors-report.html.twig');
    }
}