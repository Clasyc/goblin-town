<?php

namespace AppBundle\Controller\BooksSystem;

use AppBundle\AppBundle;
use AppBundle\Entity\Books;
use AppBundle\Form\Type\AuthorType;
use AppBundle\Form\Type\BooksType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BooksAdministrationController extends Controller
{

    /**
     * @Route("/booksAdmin/books/delete/{bookId}", name="book-delete")
     */
    public function deleteAction($bookId)
    {

        $em = $this->getDoctrine()->getEntityManager();
        $book = $em->getRepository("AppBundle:Books")->find($bookId);

        $em->remove($book);
        $em->flush();

        $this->addFlash(
            'notice',
            'Knyga istrinta'
        );

        return $this->redirectToRoute('book_admins_books-list');
    }


    /**
     * @Route("/booksAdmin/books/add", name="book_admins_book-add")
     */
    public function addBookAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();

        $admin = $em->getRepository("AppBundle:BooksAdmins")->findBooksAdminByFosUser($user->getId());
        $book = new Books();

        $form = $this->createForm(BooksType::class, $book, array(
            "allow_extra_fields" => TRUE
        ));

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $em = $this->getDoctrine()->getEntityManager();

            $book->setFkBooksAdmin($admin);
            $em->persist($book);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Knyga sėkmingai pridėta!'
            );
            return $this->redirectToRoute('book_admins_books-list');
        } else {
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

        return $this->render('default/ROLE_booksAdmin/add-book.html.twig', [
            "form" => $form->createView(),
        ]);
    }


    /**
     * @Route("/booksAdmin/books/view/{bookId}", name="book_admins_books-view")
     */
    public function booksViewAction($bookId)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $book = $em->getRepository("AppBundle:Books")->findBook(false, $bookId);

        return $this->render('default/ROLE_booksAdmin/view-book.html.twig', array(
            "books" => $book
        ));
    }

    /**
     * @Route("/booksAdmin/books/edit/{bookId}", name="book_admins_book-edit")
     */
    public function bookEditAction(Request $request, $bookId)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $book = $em->getRepository('AppBundle:Books')->find($bookId);

        $form = $this->createForm(BooksType::class, $book, array(
            'method' => 'POST'
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($book);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Knyga sėkmingai redaguota!'
            );
            return $this->redirectToRoute('book_admins_books-list');
        }

        return $this->render('default/ROLE_booksAdmin/edit-book.html.twig', [
            "form" => $form->createView(),
        ]);
    }



}
