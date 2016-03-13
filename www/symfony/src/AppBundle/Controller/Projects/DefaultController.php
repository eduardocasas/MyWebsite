<?php

namespace AppBundle\Controller\Projects;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('projects/index.html.twig');
    }
}
