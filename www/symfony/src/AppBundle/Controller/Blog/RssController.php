<?php

namespace AppBundle\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RssController extends Controller
{
    const ITEMS_PER_PAGE = 20;

    public function indexAction(Request $request, $tag_slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        return $this->render('blog/rss.xml.twig', [
            'tag' => $em->getRepository('AppBundle:Tag')->findOneBy(['slug' => $tag_slug]),
            'articles' => $em->getRepository('AppBundle:Article')->getCollectionByPageTagLanguage($request->getLocale(), $tag_slug, self::ITEMS_PER_PAGE),
        ]);
    }
}
