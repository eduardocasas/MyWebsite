<?php

namespace AppBundle\Controller\backoffice\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Article;
use AppBundle\Entity\ArticleExtend;
use AppBundle\Form\Type\blog\ArticleType;

class ArticlesController extends Controller
{

    public function createAction()
    {
        $entity = new Article;
        $form = $this->createForm(ArticleType::class, $entity);

        return $this->render('backoffice/blog/article/create.html.twig', [
            'entity' => $entity, 'form' => $form->createView()
        ]);
    }
    
    public function processCreateAction(Request $request)
    {
        $Article = new Article;
        $ArticleExtend = new ArticleExtend;
        $Article->setArticleExtend($ArticleExtend);
        $form = $this->createForm(ArticleType::class, $Article);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $Article->setDate(new \DateTime());
            $ArticleExtend->setArticle($Article);
            $em->persist($Article);
            $em->persist($ArticleExtend);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_backoffice_articles', ['id' => $Article->getId()]));
        }

        return ['entity' => $Article, 'form' => $form->createView()];
    }

    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(ArticleType::class, $entity);

        return $this->render('backoffice/blog/article/edit.html.twig', [
            'entity' => $entity,
            'form'   => $form->createView()
        ]);
    }
    
    public function processEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Article')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(ArticleType::class, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_backoffice_articles', ['id' => $id]));
        }

        return $this->render('backoffice/blog/article/edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('AppBundle:Article')->find($id);
        $em->remove($article);
        $em->flush(); 
        return $this->redirect($this->generateUrl('blog_backoffice_articles'));
    }
    
    public function indexAction()
    {
        return $this->render('backoffice/blog/article/index.html.twig', [
            'articles' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Article')->findAll()
        ]);
    }

}
