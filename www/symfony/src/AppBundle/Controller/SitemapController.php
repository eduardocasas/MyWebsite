<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Controller\blog\DefaultController as BlogDefaultController;

class SitemapController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'sitemap.xml.twig', [
                'pages' => ceil($em->getRepository('AppBundle:Article')->getTotalArticlesNum($this->getLocale())/BlogDefaultController::ITEMS_PER_PAGE),
                'articles' => $em->getRepository('AppBundle:Article')->getCollectionByPageTagLanguage($this->getLocale()),
                'tags' => $em->getRepository('AppBundle:Tag')->findAll()
            ]
        );
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
