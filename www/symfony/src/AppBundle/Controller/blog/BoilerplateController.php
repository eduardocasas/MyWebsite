<?php

namespace AppBundle\Controller\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BoilerplateController extends Controller
{
    
    public function tagCollectionAction($blog_tag_selected = null)
    {
        return $this->render('blog/boilerplate/tag_collection.html.twig', [
            'blog_tag_selected' => $blog_tag_selected,
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll()
        ]);
    }
    
    public function githubCollectionAction()
    {
        return $this->render('blog/boilerplate/github_collection.html.twig', [
            'github_collection' => simplexml_load_file('https://github.com/eduardocasas.atom')->entry
        ]);
    }
    
}
