<?php

namespace ECL\CurriculumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ECLCurriculumBundle:Default:index.html.twig');
    }
}
