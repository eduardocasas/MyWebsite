<?php
namespace ECL\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->redirect(
            $this->generateUrl('ecl_home_homepage',
            ['_locale' => $this->getRequest()->getPreferredLanguage(['en', 'es'])]
        ));
    }

}
