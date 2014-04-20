<?php
namespace ECL\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoilerplateController extends Controller
{
    
    public function tagCollectionAction($blog_tag_selected = null)
    {
        return $this->render(
            'ECLBlogBundle:'.$this->get('my.browser')->getFolder().'/Boilerplate:tag_collection.html.twig',
            array(
                'blog_tag_selected' => $blog_tag_selected,
                'tags'              => $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Tag')->findAll()
            )
        );
    }
    
    public function githubCollectionAction()
    {
        return $this->render(
            'ECLBlogBundle:pc/Boilerplate:github_collection.html.twig',
            array('github_collection' => simplexml_load_file('https://github.com/eduardocasas.atom')->entry)
        );                
    }
    
}
