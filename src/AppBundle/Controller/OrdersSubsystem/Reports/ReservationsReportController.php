<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ReservationsReportController extends Controller
{
    /**
     * @Route("/employee/report/reservations", name="orders_employee-reservations-report")
     */
    public function getReservationsReportWindowAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $beginDate = $request->request->get("beginDate");
        $endDate = $request->request->get("endDate");

        if (!empty($beginDate) && !empty($endDate))
        {
            $reservations = $em->getRepository('AppBundle:Reservations')->findReservationsByDateForReport($beginDate, $endDate);

            if (count($reservations) < 1)
            {
                $this->addFlash(
                    'error',
                    'Nurodytame intervale, rezervacijų nėra.'
                );
            }
            else
            {
                return $this->render('default/ROLE_employee/reservations-report.html.twig', [
                    "reservations" => $reservations,
                    "bd" => $beginDate, "ed" => $endDate,
                ]);
            }
        }

        return $this->render('default/ROLE_employee/reservations-report.html.twig');
    }
}