<?php

namespace AppBundle\Controller\Backoffice\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Blog\BackofficeCommentType;

class CommentsController extends Controller
{
    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository('AppBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(BackofficeCommentType::class, $entity);

        return $this->render('backoffice/blog/comment/edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    public function processEditAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(BackofficeCommentType::class, $entity);
        $editForm->handleRequest($request);
        if ($editForm->isValid()) {
            $entity->setUpdateDate(new \DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('blog_backoffice_comments', ['id' => $id]));
        }

        return $this->render('backoffice/blog/comment/edit.html.twig', [
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
        ]);
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('AppBundle:Comment')->find($id);
        $em->remove($comment);
        $em->flush();

        return $this->redirect($this->generateUrl('blog_backoffice_comments'));
    }

    public function indexAction()
    {
        return $this->render('backoffice/blog/comment/index.html.twig', [
            'comments' => $this->getDoctrine()->getManager()->getRepository('AppBundle:Comment')->getAll(),
        ]);
    }
}
