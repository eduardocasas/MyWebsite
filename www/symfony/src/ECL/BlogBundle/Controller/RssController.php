<?php
namespace ECL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RssController extends Controller
{
    
    const ITEMS_PER_PAGE = 20;
    
    public function indexAction($tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render('ECLBlogBundle:rss:index.xml.twig', [
            'tag' => $em->getRepository('ECLBlogBundle:Tag')->findOneBy(['slug' => $tag_slug]),
            'articles' => $em->getRepository('ECLBlogBundle:Article')->getCollectionByPageTagLanguage($this->getLocale(), $tag_slug, self::ITEMS_PER_PAGE)
        ]);
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
