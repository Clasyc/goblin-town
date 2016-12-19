<?php

namespace AppBundle\Controller\OrdersSubsystem\Reports;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class OrdersReportController extends Controller
{
    /**
     * @Route("/employee/report/orders", name="orders_employee-orders-report")
     */
    public function getOrdersReportWindowAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $beginDate = $request->request->get("beginDate");
        $endDate = $request->request->get("endDate");
        $reader = $request->request->get("reader");

        if (is_numeric($reader))
        {
            if (!empty($beginDate) && !empty($endDate) && !empty($reader))
            {
                $orders = $em->getRepository('AppBundle:Orders')->findOrdersByDateAndReaderForReport($beginDate, $endDate, $reader);

                if (count($orders) < 1)
                {
                    $this->addFlash(
                        'error',
                        'Nurodytame intervale, nurodyto skaitytojo užsakymų nėra.'
                    );
                }
                else
                {
                    return $this->render('default/ROLE_employee/orders-report.html.twig', [
                        "orders" => $orders,
                        "bd" => $beginDate, "ed" => $endDate,
                        "rd" => $reader
                    ]);
                }
            }
        }
        else
        {
            $this->addFlash(
                'error',
                'Skaitytojo asmens kodas turi būti sudarytas iš skaitmenų.'
            );
        }

        return $this->render('default/ROLE_employee/orders-report.html.twig');
    }
}