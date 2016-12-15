<?php

// src/Acme/UserBundle/EventListener/PasswordResettingListener.php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Listener responsible to change the redirection at the end of the password resetting
 */
class ChangePasswordListener implements EventSubscriberInterface
{
    private $router;

    public function __construct(UrlGeneratorInterface $router, AuthorizationChecker $authorizationChecker)
    {
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::CHANGE_PASSWORD_SUCCESS => 'onChangePasswordSuccess',
        );
    }

    public function onChangePasswordSuccess(FormEvent $event)
    {

        if ($this->authorizationChecker->isGranted('ROLE_READER')) {
            $url = $this->router->generate('readers_books-list');
        }else if ($this->authorizationChecker->isGranted('ROLE_READERS_ADMIN')) {
            $url = $this->router->generate('readers-admin_readers-list');
        }else if ($this->authorizationChecker->isGranted('ROLE_EMPLOYEE')) {
            $url = $this->router->generate('orders_employee-orders-list');
        }


        $event->setResponse(new RedirectResponse($url));
    }
}