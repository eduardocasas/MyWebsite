<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\blog\DefaultController as BlogDefaultController;

class SitemapController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'sitemap.xml.twig', [
                'pages' => ceil($em->getRepository('AppBundle:Article')->getTotalArticlesNum($request->getLocale())/BlogDefaultController::ITEMS_PER_PAGE),
                'articles' => $em->getRepository('AppBundle:Article')->getCollectionByPageTagLanguage($request->getLocale()),
                'tags' => $em->getRepository('AppBundle:Tag')->findAll()
            ]
        );
    }
    
}
