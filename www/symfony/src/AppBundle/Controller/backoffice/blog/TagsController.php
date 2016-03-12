<?php

namespace AppBundle\Controller\backoffice\blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Tag;
use AppBundle\Form\Type\blog\TagType;

class TagsController extends Controller
{

    public function createAction()
    {
        $entity = new Tag;
        $form = $this->createForm(TagType::class, $entity);

        return $this->render('backoffice/blog/tag/create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
    
    public function processCreateAction(Request $request)
    {
        $entity = new Tag;
        $form = $this->createForm(TagType::class, $entity);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_backoffice_tags', ['id' => $entity->getId()]));
        }

        return ['entity' => $entity, 'form'   => $form->createView()];
    }

    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(TagType::class, $entity);

        return $this->render('backoffice/blog/tag/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
    
    public function processEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Tag')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(TagType::class, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_backoffice_tags', ['id' => $id]));
        }

        return $this->render('backoffice/blog/tag/edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView()
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $tag = $em->getRepository('AppBundle:Tag')->find($id);
        $em->remove($tag);
        $em->flush();

        return $this->redirect($this->generateUrl('blog_backoffice_tags'));
    }
    
    public function indexAction()
    {
        return $this->render('backoffice/blog/tag/index.html.twig', [
            'tags' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Tag')->findAll()
        ]);
    }

}
