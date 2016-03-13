<?php

namespace AppBundle\Controller\Curriculum;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('curriculum/index.html.twig');
    }
}
