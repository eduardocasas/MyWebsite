<?php

namespace AppBundle\Controller\Backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class DefaultController extends Controller
{
    public function loginAction(Request $request)
    {
        $session = $request->getSession();
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        }

        return $this->render('backoffice/login.html.twig', [
            'last_username' => $session->get(Security::LAST_USERNAME),
            'error' => $error,
        ]);
    }

    public function indexAction()
    {
        return $this->render('backoffice/index.html.twig');
    }
}
