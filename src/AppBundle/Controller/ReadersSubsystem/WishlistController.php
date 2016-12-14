<?php

namespace AppBundle\Controller\ReadersSubsystem;

use AppBundle\Entity\Wishlists;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class WishlistController extends Controller
{
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
