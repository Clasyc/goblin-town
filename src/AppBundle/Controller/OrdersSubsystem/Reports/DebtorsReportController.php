<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DebtorsReportController extends Controller
{
    /**
     * @Route("/employee/report/debtors", name="orders_employee-debtors-report")
     */
    public function getDebtorsReportWindowAction()
    {
        return $this->render('default/ROLE_employee/debtors-report.html.twig');
    }
}