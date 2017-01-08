<?php

namespace AppBundle\Controller\ReadersSubsystem;

use AppBundle\Entity\Penalty;
use AppBundle\Form\Type\ReaderRegistration_NoFosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReaderController extends Controller
{

    /**
     * @Route("/reader/books-list/{page}", name="readers_books-list")
     */
    public function booksListAction(Request $request, $page = 1)
    {
        $items_per_page = 25;

        $em = $this->getDoctrine()->getEntityManager();
        // metodas patikrina ar nėra užsidelsusių rezervacijų
        // tarkim žmogus prieina savo eilę užsisakyti knygą, bet uždelsia per ilgai (1 para)
        // tai šis metodas tikrina ar ne per ilgai uždelsta, jei taip - atnaujina knygos ordered atributą
        $outdatedReservationsBooks = $em->getRepository('AppBundle:Books')->getOutdatedReservationsBooksIds();
        $em->getRepository('AppBundle:Books')->checkBookReservations($outdatedReservationsBooks);


        if(!empty($request->request->all())){
                $filters = $request->request->all();
                $books = $em->getRepository("AppBundle:Books")->findAllBooksByFilters($filters, true);
                $request->getSession()->set("filters", $filters);
        }else if(!empty($request->getSession()->get("filters"))){
            $books = $em->getRepository("AppBundle:Books")->findAllBooksByFilters($request->getSession()->get("filters"), true);
        }else{
            $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);
        }

        $wishlist = $em->getRepository("AppBundle:Books")->findBooksInWishlist($this->getReaderId(), true);


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            $items_per_page/*limit per page*/
        );
        $wishlist_books = $paginator->paginate(
            $wishlist, /* query NOT result */
            $page/*page number*/,
            $items_per_page/*limit per page*/
        );



        foreach ($pagination as $book) {
            foreach ($wishlist_books as $w_book) {
                if ($book->getId() == $w_book->getId()) {
                    $book->setMarked(true);
                }
            }
        }


        return $this->render('default/ROLE_reader/index.html.twig', [
            "pagination" => $pagination
        ]);
    }

    /**
     * @Route("/reader/profile", name="readers_edit-profile")
     */
    public function editProfileAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        if (empty($reader))
            return $this->redirectToRoute("readers_books-list");

        $form = $this->createForm(ReaderRegistration_NoFosType::class, $reader, array(
            'method' => 'POST',
            'validation_groups' => array('profile'),
            'attr' => array('class' => 'col-sm-10 col-sm-offset-1')
        ));

        $form->handleRequest($request);
        $reader->getFosuser()->setEmail($reader->getEmail());

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();

            $em->persist($reader);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Profilis sėkmingai redaguotas!'
            );
            return $this->redirectToRoute('readers_books-list');
        }

        return $this->render('default/ROLE_reader/profile-edit.html.twig', [
            "reader" => $reader,
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/readers-admin/readers-list/{page}", name="readers-admin_readers-list")
     */
    public function readersListAction($page = 1)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Readers")->findAllReaders(true);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $books, /* query NOT result */
            $page/*page number*/,
            10/*limit per page*/
        );

        return $this->render('default/ROLE_readers_admin/index.html.twig', [
            "pagination" => $pagination
        ]);
    }

    /**
     * @Route("/readers-admin/reader/edit/{readerId}", name="readers-admin_reader-edit")
     */
    public function editReaderAction(Request $request, $readerId = null)
    {
        $em = $this->getDoctrine()->getEntityManager();
        if ($readerId === null || !ctype_digit($readerId))
            return $this->redirectToRoute("readers-admin_readers-list");

        $reader = $em->getRepository("AppBundle:Readers")->findReader($readerId);


        if (empty($reader))
            return $this->redirectToRoute("readers-admin_readers-list");


        $form = $this->createForm(ReaderRegistration_NoFosType::class, $reader, array(
            'method' => 'POST',
            'validation_groups' => array('profile'),
            'attr' => array('class' => 'col-sm-10 col-sm-offset-1')
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $reader->getFosuser()->setEmail($reader->getEmail());

            $em->persist($reader);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Skaitytojas ' . $reader->getName() . " " . $reader->getLastName() . " sėkmingai redaguotas!"
            );
            return $this->redirectToRoute('readers-admin_readers-list');
        }else{
            $errors = $form->getErrors(true);
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $request->getSession()->getFlashBag()->add(
                        'error',
                        $error->getMessage()
                    );
                }
            }
        }

        return $this->render('default/ROLE_readers_admin/reader-edit.html.twig', [
            "reader" => $reader,
            "form" => $form->createView()
        ]);
    }

    private function getReaderId()
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }

    /**
     * @Route("/readers-admin/reader/check_delete", name="readers-admin_delete-check-reader")
     */
    public function ajaxCheckDeleteReaderAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getEntityManager();
            $readerId = $request->get("reader");
            $orders_count = $em->getRepository("AppBundle:Orders")->findOrdersCount($readerId);


            $response = new JsonResponse(array(
                "orders_number" => $orders_count,
                "url" => $this->generateUrl("readers-admin_readers-list")
            ));
            return $response;
        }
    }

    /**
     * @Route("/readers-admin/reader/delete", name="readers-admin_delete-reader")
     */
    public function ajaxDeleteReaderAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $em = $this->getDoctrine()->getEntityManager();
            $readerId = $request->get("reader");


            $reader = $em->getRepository("AppBundle:Readers")->find($readerId);
            $Fos_reader = $em->getRepository("AppBundle:Readers")->find($readerId)->getFosuser();


            $Fos_reader->setEnabled(false);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Skaitytojas ' . $reader->getName() . " " . $reader->getLastName() . " sėkmingai pašalintas!"
            );

            $response = new JsonResponse(array(
                "deleted" => true,
            ));
            return $response;
        }
    }

    /**
     * @Route("/employee/reader/{id}", name="orders_employee-get-reader")
     */
    public function getReaderFormAction($id)
    {
        $reader = $this->getDoctrine()
            ->getRepository('AppBundle:Readers')
            ->find($id);

        if (empty($reader))
        {
            $this->addFlash(
                'error',
                'Skaitytojas nerastas.'
            );
            return $this->redirectToRoute('orders_employee-orders-list');
        }

        return $this->render('default/ROLE_employee/reader-info.html.twig', ['reader' => $reader]);
    }



}
