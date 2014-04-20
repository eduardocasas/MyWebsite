<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ECLHomeBundle:'.$this->get('my.browser')->getFolder().'/Default:index.html.twig');
    }

}
