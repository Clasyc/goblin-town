<?php

namespace AppBundle\Controller\ReadersSubsystem\Reports;

use AppBundle\Entity\Wishlists;
use AppBundle\Form\Type\ReaderRegistration_NoFosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReportsController extends Controller
{
    /**
     * @Route("/reader/report", name="readers_report")
     */
    public function readersReportAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        $beginDate = $request->request->get("beginDate");
        $endDate = $request->request->get("endDate");
        if(!empty($beginDate) && !empty($endDate)){
            $categories = $em->getRepository("AppBundle:Orders")->findOrdersGroupsCountForReport($reader->getPersonalId(), $beginDate, $endDate);
            $languages = $em->getRepository("AppBundle:Orders")->findOrdersLanguagesCountForReport($reader->getPersonalId(), $beginDate, $endDate);
            $total = $em->getRepository("AppBundle:Orders")->findOrdersCountForReport($reader->getPersonalId(), $beginDate, $endDate);
            //dump($total);dump($categories);die();
            return $this->render('default/ROLE_reader/report.html.twig', [
                "categories" => $categories,
                "languages" => $languages,
                "total" => $total,
                "bd" => $beginDate,
                "ed" => $endDate
            ]);
        }


       // dump($eew);die();


        return $this->render('default/ROLE_reader/report.html.twig', [

        ]);
    }

    /**
     * @Route("/readers-admin/report", name="readers-admin_report")
     */
    public function readersRegistrationReportAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $beginDate = $request->request->get("beginDate");
        $endDate = $request->request->get("endDate");
        if(!empty($beginDate) && !empty($endDate)){
            $readers = $em->getRepository("AppBundle:Readers")->findReadersRegistrationCountsForReport($beginDate, $endDate);

            $readers_array = $this->readersToArray($readers);

            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod(new \DateTime($beginDate), $interval, new \DateTime($endDate));

            $dates = array();
            foreach ( $period as $dt ){
                $key = $dt->format("Y-m-d");
                if(isset($readers_array[$key])){
                    $tmp["date"] = $key;
                    $tmp["value"] = $readers_array[$key];
                    array_push($dates, $tmp);
                }else{
                    $tmp["date"] = $key;
                    $tmp["value"] = 0;
                    array_push($dates, $tmp);
                }
            }
            
            return $this->render('default/ROLE_readers_admin/report.html.twig', [
                "dates" => $dates,
                "bd" => $beginDate,
                "ed" => $endDate
            ]);
        }
        return $this->render('default/ROLE_readers_admin/report.html.twig', [

        ]);
    }
    private function readersToArray($r){
        $array = array();
        foreach($r as $reader){
            $dates = explode(" ", $date = $reader[0]->getFosuser()->getRegistrationDate());
            $array[$dates[0]] = $reader['cnt'];
        }
        return $array;
    }

}
