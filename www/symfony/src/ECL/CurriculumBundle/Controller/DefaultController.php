<?php

namespace ECL\CurriculumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('ECLCurriculumBundle:'.$this->get('my.browser')->getFolder().'/Default:index.html.twig', array());
    }
}
