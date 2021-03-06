<?php
/**
 * Created by PhpStorm.
 * User: Clasyc
 * Date: 10/08/2016
 * Time: 15:30
 */

namespace AppBundle\Security;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface {

    protected $router;
    protected $authorizationChecker;

    public function __construct(Router $router, AuthorizationChecker $authorizationChecker) {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token) {

        $response = null;

        if ($this->authorizationChecker->isGranted('ROLE_READER')) {
            $response = new RedirectResponse($this->router->generate('readers_books-list'));
        }else if ($this->authorizationChecker->isGranted('ROLE_READERS_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('readers-admin_readers-list'));
        }else if ($this->authorizationChecker->isGranted('ROLE_BOOKS_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('book_admins-list-search'));
        }else if ($this->authorizationChecker->isGranted('ROLE_EMPLOYEE')) {
            $response = new RedirectResponse($this->router->generate('orders_employee-orders-list'));
        }

        return $response;
    }

}