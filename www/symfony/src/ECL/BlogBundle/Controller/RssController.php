<?php
namespace ECL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RssController extends Controller
{
    
    const ITEMS_PER_PAGE = 20;
    
    public function indexAction($tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        return $this->render(
            'ECLBlogBundle:rss:index.xml.twig',
            array(
                'tag'      => $em->getRepository('ECLBlogBundle:Tag')->findOneBy(array('slug' => $tag_slug)),
                'articles' => $em->getRepository('ECLBlogBundle:Article')->getCollectionByPageTagLanguage($tag_slug, self::ITEMS_PER_PAGE, null, $this->getLocale())
            )
        );
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
