<?php

namespace AppBundle\Controller\curriculum;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('curriculum/index.html.twig');
    }
    
}
