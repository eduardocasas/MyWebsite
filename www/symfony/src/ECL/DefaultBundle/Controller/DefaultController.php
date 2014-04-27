<?php
namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->redirect(
            $this->generateUrl('ecl_home_homepage',
            array('_locale' => $this->getRequest()->getPreferredLanguage(array('en', 'es'))))
        );
    }

}
