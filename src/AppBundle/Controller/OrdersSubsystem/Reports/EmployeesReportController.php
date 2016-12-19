<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmployeesReportController extends Controller
{
    /**
     * @Route("/employee/reports-list", name="orders_employee-reports-list")
     */
    public function getReportsWindowAction()
    {
        return $this->render('default/ROLE_employee/reports-list.html.twig');
    }
}