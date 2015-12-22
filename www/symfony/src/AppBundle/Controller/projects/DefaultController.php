<?php

namespace AppBundle\Controller\projects;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('projects/index.html.twig');
    }
}
