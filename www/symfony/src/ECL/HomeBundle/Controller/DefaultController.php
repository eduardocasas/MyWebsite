<?php
namespace ECL\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\BlogBundle\Controller\DefaultController as BlogDefaultController;

class DefaultController extends Controller
{

    public function indexAction()
    {
        return $this->render('ECLHomeBundle:Default:index.html.twig');
    }
    
    public function sitemapAction()
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'ECLHomeBundle:Default:sitemap.html.twig', [
                'pages' => ceil($em->getRepository('ECLBlogBundle:Article')->getTotalArticlesNum($this->getLocale())/BlogDefaultController::ITEMS_PER_PAGE),
                'articles' => $em->getRepository('ECLBlogBundle:Article')->getCollectionByPageTagLanguage($this->getLocale()),
                'tags' => $em->getRepository('ECLBlogBundle:Tag')->findAll()
            ]
        );
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
