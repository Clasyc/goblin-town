<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ReaderRegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Readers;

use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class LoginController extends Controller
{
    /**
     * @Route("/", name="login")
     */
    public function indexAction(Request $request)
    {

        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        $authErrorKey = Security::AUTHENTICATION_ERROR;
        $lastUsernameKey = Security::LAST_USERNAME;

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        $csrfToken = $this->has('security.csrf.token_manager')
            ? $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue()
            : null;


        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->get('fos_user.user_manager');


        $user = $userManager->createUser();

        $reader = new Readers();

        $reader->setFkFosuser($user);

        $form = $this->createForm(ReaderRegistrationType::class, $reader, array(
            'action' => $this->generateUrl("login"),
            'method' => 'POST',
            'validation_groups' => array('Readers','profile', 'Fosuser'),
            'attr' => array('class' => 'login-form'),
        ));

        $form->handleRequest($request);
        $user->setEmail($reader->getEmail());

        if ($form->isSubmitted() && $form->isValid()) {

            $form->getData();
            $user->setRoles(["ROLE_READER"]);
            $user->setEnabled(true);

            $userManager->updateUser($user);

            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($reader);
            $em->flush();

            $request->getSession()->getFlashBag()->add(
                'success',
                'Sėkmingai prisiregistravote, galite prisijungti.'
            );
            return $this->redirectToRoute('login');
        } else {
            $errors = $form->getErrors(true);
            if (!empty($errors)) {
                $isError = false;
                foreach ($errors as $error) {
                    $isError = true;
                }
                if($isError){
                    return $this->render('default/login_register_only.html.twig', [
                        'form' => $form->createView(),
                    ]);
                }

            }

        }


        return $this->render('default/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ]);
    }
}
