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

    /**
     * @Route("/employee/report/orders", name="orders_employee-orders-report")
     */
    public function getOrdersReportWindowAction()
    {
        return $this->render('default/ROLE_employee/orders-report.html.twig');
    }

    /**
     * @Route("/employee/report/reservations", name="orders_employee-reservations-report")
     */
    public function getReservationsReportWindowAction()
    {
        return $this->render('default/ROLE_employee/reservations-report.html.twig');
    }

    /**
     * @Route("/employee/report/debtors", name="orders_employee-debtors-report")
     */
    public function getDebtorsReportWindowAction()
    {
        return $this->render('default/ROLE_employee/debtors-report.html.twig');
    }
}