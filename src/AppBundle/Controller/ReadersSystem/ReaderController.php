<?php

namespace AppBundle\Controller\ReadersSystem;

use AppBundle\Entity\Wishlists;
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
    public function booksListAction($page = 1)
    {
        $items_per_page = 25;

        $em = $this->getDoctrine()->getEntityManager();
        $books = $em->getRepository("AppBundle:Books")->findAllBooks(true);

        $wishlist = $em->getRepository("AppBundle:Books")->findBooksInWishlist($this->getReaderId(), true);


        $paginator  = $this->get('knp_paginator');
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

        foreach($pagination as $book){
            foreach($wishlist_books as $w_book){
                if($book->getId() == $w_book->getId()){
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

        if(empty($reader))
            return $this->redirectToRoute("readers_books-list");

        $form = $this->createForm(ReaderRegistration_NoFosType::class, $reader, array(
            'method' => 'POST',
            'validation_groups' => array('Reader'),
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
     * @Route("/reader/ajax-wishlist-toggle", name="readers_wishlist-toggle")
     */
    public function wishlistToggleAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        if ($request->isXmlHttpRequest()) {
            $bookId = $request->get("book");

            $book = $em->getRepository("AppBundle:Books")->find($bookId);
            if(empty($book))
                return $this->generateUrl("readers_books-list");

            $user = $this->get('security.token_storage')->getToken()->getUser();

            $wishlist = $em->getRepository("AppBundle:Wishlists")->findWishlist($user->getId(), $bookId);

            $empty = true;
            if(!empty($wishlist)){
                $em->remove($wishlist[0]);
                $em->flush();
                $empty = false;
            }else{
                $wishlist = new Wishlists();
                $wishlist->setFkBook($book);
                $wishlist->setAdditionDate(new \DateTime());
                $wishlist->setFkReader($em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId()));

                $em->persist($wishlist);
                $em->flush();
            }

            $response = new JsonResponse(array(
                "empty" => $empty,
            ));
            return $response;
        }
    }

    /**
     * @Route("/reader/wishlist/{page}", name="readers_wishlist")
     */
    public function wishlistAction($page = 1)
    {
        $items_per_page = 25;

        $em = $this->getDoctrine()->getEntityManager();

        $wishlist = $em->getRepository("AppBundle:Books")->findBooksInWishlist($this->getReaderId(), true);


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $wishlist, /* query NOT result */
            $page/*page number*/,
            $items_per_page/*limit per page*/
        );

        return $this->render('default/ROLE_reader/wishlist.html.twig', [
            "pagination" => $pagination
        ]);
    }

    private function getReaderId(){
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $reader = $em->getRepository("AppBundle:Readers")->findReaderByFosUser($user->getId());

        return $reader->getPersonalId();
    }
}
