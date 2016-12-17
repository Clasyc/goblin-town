<?php

namespace AppBundle\Controller\BooksSystem;

use AppBundle\AppBundle;
use AppBundle\Entity\Books;
use AppBundle\Form\Type\AuthorType;
use AppBundle\Form\Type\BooksType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class BooksOrderReportController extends Controller
{
    /**
     * @Route("/booksAdmin/books-report/form", name="book_admins_books-report-form")
     */
    public function orderedBooksAction(Request $request, $page = 1)
    {

        $defaultData = array('message' => 'Type your message here');
        $form = $this->createFormBuilder($defaultData)
            ->add('startDate', DateType::class, array(
                'label' => 'Pradžios data',
                'years' => range(date('Y'), date('Y') - 5)
            ))
            ->add('endDate', DateType::class, array(
                'label' => 'Pabaigos data',
                'years' => range(date('Y'), date('Y') - 5),
                'data' => new \DateTime()
            ))
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = $form['startDate']->getData();
            $endDate = $form['endDate']->getData();

            if($startDate < $endDate) {
                $em = $this->getDoctrine()->getEntityManager();
                $books = $em->getRepository("AppBundle:Books")->findOrderedBooks(true, $startDate, $endDate);

                $paginator = $this->get('knp_paginator');
                $pagination = $paginator->paginate(
                    $books, /* query NOT result */
                    $page/*page number*/,
                    10/*limit per page*/
                );

                return $this->render('default/ROLE_booksAdmin/report-list.html.twig', [
                    "pagination" => $pagination
                ]);
            }
        }
        else{
            $errors = $form->getErrors(true);
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $request->getSession()->getFlashBag()->add(
                        'error',
                        $error->getMessage()
                    );
                    $isError = true;
                }
            }
        }

        return $this->render('default/ROLE_booksAdmin/report.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
