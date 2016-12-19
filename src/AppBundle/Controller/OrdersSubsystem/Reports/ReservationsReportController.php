<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ReservationsReportController extends Controller
{
    /**
     * @Route("/employee/report/reservations", name="orders_employee-reservations-report")
     */
    public function getReservationsReportWindowAction()
    {
        return $this->render('default/ROLE_employee/reservations-report.html.twig');
    }
}