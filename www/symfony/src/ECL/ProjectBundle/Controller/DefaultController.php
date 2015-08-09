<?php

namespace ECL\ProjectBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ECLProjectBundle:Default:index.html.twig');
    }
}
