<?php
namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoilerplateController extends Controller
{
    
    public function browserStyleAction()
    {
        return $this->render(
            'ECLDefaultBundle:mobile:browser_style.html.twig',
            array('isWebkitBrowser' => $this->get('my.browser')->hasWebKitRenderingEngine())
        );
    }
    
}
