<?php

namespace ECL\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ECLFileBundle:Default:index.html.twig', ['name' => $name]);
    }
}
