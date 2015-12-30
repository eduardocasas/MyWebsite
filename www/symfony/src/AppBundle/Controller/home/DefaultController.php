<?php

namespace AppBundle\Controller\home;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function redirectRootAction(Request $request)
    {
        return $this->redirect(
            $this->generateUrl('home', ['_locale' => $request->getPreferredLanguage(['en', 'es'])]),
            301
        );
    }
    
    public function indexAction()
    {
        return $this->render('home/index.html.twig');
    }
    
}
