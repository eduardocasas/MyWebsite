<?php
namespace ECL\BlogBundle\Controller\backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\BlogBundle\Entity\Article;
use ECL\BlogBundle\Entity\ArticleExtend;
use ECL\BlogBundle\Form\Type\ArticleType;

class ArticlesController extends Controller
{

    public function createAction()
    {
        $entity = new Article;
        $form = $this->createForm(new ArticleType, $entity);

        return $this->render(
            'ECLBlogBundle:pc/backoffice/article:create.html.twig',
            array('entity' => $entity, 'form' => $form->createView())
        );
    }
    
    public function processCreateAction()
    {
        $Article = new Article;
        $ArticleExtend = new ArticleExtend;
        $Article->setArticleExtend($ArticleExtend);
        $form = $this->createForm(new ArticleType, $Article);
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Article->setDate(new \DateTime());
            $ArticleExtend->setArticle($Article);
            $em->persist($Article);
            $em->persist($ArticleExtend);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'ecl_blog_backoffice_articles',
                array('id' => $Article->getId())
            ));
        }

        return array(
            'entity' => $Article,
            'form'   => $form->createView()
        );
    }

    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Article')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(new ArticleType, $entity);

        return $this->render(
            'ECLBlogBundle:pc/backoffice/article:edit.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }
    
    public function processEditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ECLBlogBundle:Article')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(new ArticleType, $entity);
        $editForm->bind($this->getRequest());
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'ecl_blog_backoffice_articles',
                array('id' => $id)
            ));
        }

        return $this->render(
            'ECLBlogBundle:pc/backoffice/article:edit.html.twig',
            array(
                'entity'    => $entity,
                'edit_form' => $editForm->createView()
            )
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('ECLBlogBundle:Article')->find($id);
        $em->remove($article);
        $em->flush(); 
        return $this->redirect($this->generateUrl('ecl_blog_backoffice_articles'));
    }
    
    public function indexAction()
    {
        return $this->render(
            'ECLBlogBundle:pc/backoffice/article:index.html.twig',
            array(
                'articles' => $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Article')->findAll()
            )
        );
    }

}
