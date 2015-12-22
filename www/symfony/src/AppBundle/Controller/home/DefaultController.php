<?php

namespace AppBundle\Controller\home;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function redirectRootAction()
    {
        return $this->redirect(
            $this->generateUrl('home', ['_locale' => $this->getRequest()->getPreferredLanguage(['en', 'es'])]),
            301
        );
    }
    
    public function indexAction()
    {
        return $this->render('home/index.html.twig');
    }
    
}
