<?php

namespace AppBundle\Controller\ReadersSubsystem;

use AppBundle\Entity\Penalty;
use AppBundle\Form\Type\ReaderRegistration_NoFosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PenaltyController extends Controller
{
    /**
     * @Route("/readers-admin/reader/penalty/check", name="readers-admin_check-penalty-reader")
     */
    public function ajaxCheckPenaltyReaderAction(Request $request)
    {

        if ($request->isXmlHttpRequest()) {
            $typ = $request->get("type");

            $em = $this->getDoctrine()->getEntityManager();
            $readerId = $request->get("reader");

            $reader = $em->getRepository("AppBundle:Readers")->find($readerId);

            if (empty($reader)) {
                $response = new JsonResponse(array(
                    "status" => "empty",
                ));
                return $response;
            }
            if ($em->getRepository("AppBundle:Penalty")->isActivePenalty($readerId)) {
                $response = new JsonResponse(array(
                    "status" => "active",
                ));
                return $response;
            }


            if ($typ == "check") {
                $response = new JsonResponse(array(
                    "name" => $reader->getName() . " " . $reader->getLastName(),
                    "status" => "ok",
                ));
            } else if ($typ == "delete") {
                $penalty = new Penalty();

                $user = $this->get('security.token_storage')->getToken()->getUser();
                $readerAdmin = $em->getRepository("AppBundle:ReadersAdmin")->findReadersAdminByFosUser($user->getId());

                $date = $request->get("date");
                $name = $request->get("name");
                $comment = $request->get("comment");

                if((\DateTime::createFromFormat('Y-m-d', $date) === FALSE)){
                    $response = new JsonResponse(array(
                        "status" => "error",
                    ));
                    return $response;
                }
                $penalty->setFkReader($reader);
                $penalty->setFkReadersAdmin($readerAdmin);
                $penalty->setPenaltyBeginDate(new \DateTime());
                $penalty->setPenaltyEndDate(new \DateTime($date));
                $penalty->setName($name);
                $penalty->setComment($comment);

                $validator = $this->get('validator');
                $errors = $validator->validate($penalty);

                if (count($errors) > 0) {
                    $response = new JsonResponse(array(
                        "status" => "error",
                    ));
                    return $response;
                }

                $em->persist($penalty);
                $em->flush();
                $penalty_id = $penalty->getId();

                $response = new JsonResponse(array(
                    "name" => $reader->getName() . " " . $reader->getLastName(),
                    "status" => "ok",
                    "id" => $penalty_id,
                    "date" => $penalty->getPenaltyBeginDate()->format('Y-m-d H:i:s')."-".$penalty->getPenaltyEndDate()->format("Y-m-d")
                ));

            }
            return $response;
        }
    }

    /**
     * @Route("/readers-admin/reader/penalty/delete", name="readers-admin_delete-penalty-reader")
     */
    public function ajaxDeletePenaltyReaderAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getEntityManager();
            $penaltyId = $request->get("penalty");

            $penalty = $em->getRepository("AppBundle:Penalty")->find($penaltyId);
            if(empty($penalty)){
                $response = new JsonResponse(array(
                    "deleted" => false,
                ));
                return $response;
            }
            $em->remove($penalty);
            $em->flush();

            $response = new JsonResponse(array(
                "deleted" => true,
            ));
            return $response;
        }
    }

}
