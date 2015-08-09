<?php
namespace ECL\BlogBundle\Controller\backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\BlogBundle\Entity\Tag;
use ECL\BlogBundle\Form\Type\TagType;

class TagsController extends Controller
{

    public function createAction()
    {
        $entity = new Tag;
        $form = $this->createForm(new TagType, $entity);

        return $this->render('ECLBlogBundle:backoffice/tag:create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
    
    public function processCreateAction()
    {
        $entity = new Tag;
        $form = $this->createForm(new TagType, $entity);
        $form->bind($this->getRequest());
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ecl_blog_backoffice_tags', [
                'id' => $entity->getId()
            ]));
        }

        return ['entity' => $entity, 'form'   => $form->createView()];
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ECLBlogBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(new TagType, $entity);

        return $this->render('ECLBlogBundle:backoffice/tag:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
    
    public function processEditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ECLBlogBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(new TagType, $entity);
        $editForm->bind($this->getRequest());
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ecl_blog_backoffice_tags', ['id' => $id]));
        }

        return $this->render('ECLBlogBundle:backoffice/tag:edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('ECLBlogBundle:Tag')->find($id);
        $em->remove($tag);
        $em->flush(); 
        return $this->redirect($this->generateUrl('ecl_blog_backoffice_tags'));
    }
    
    public function indexAction()
    {
        return $this->render('ECLBlogBundle:backoffice/tag:index.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Tag')->findAll()
        ]);
    }

}
