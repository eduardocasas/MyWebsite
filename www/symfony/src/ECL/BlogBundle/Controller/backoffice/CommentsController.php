<?php
namespace ECL\BlogBundle\Controller\backoffice;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\BlogBundle\Form\Type\BackofficeCommentType;

class CommentsController extends Controller
{

    public function editAction($id)
    {
        $entity = $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $form = $this->createForm(new BackofficeCommentType, $entity);

        return $this->render(
            'ECLBlogBundle:pc/backoffice/comment:edit.html.twig',
            array(
                'entity' => $entity,
                'form'   => $form->createView()
            )
        );
    }
    
    public function processEditAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('ECLBlogBundle:Comment')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Users entity.');
        }
        $editForm = $this->createForm(new BackofficeCommentType, $entity);
        $editForm->bind($this->getRequest());
        if ($editForm->isValid()) {
            $entity->setUpdateDate(new \DateTime());
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl(
                'ecl_blog_backoffice_comments',
                array('id' => $id)
            ));
        }

        return $this->render(
            'ECLBlogBundle:pc/backoffice/comment:edit.html.twig',
            array(
                'entity'    => $entity,
                'edit_form' => $editForm->createView()
            )
        );
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('ECLBlogBundle:Comment')->find($id);
        $em->remove($comment);
        $em->flush(); 
        return $this->redirect($this->generateUrl('ecl_blog_backoffice_comments'));
    }
    
    public function indexAction()
    {
        return $this->render(
            'ECLBlogBundle:pc/backoffice/comment:index.html.twig',
            array(
                'comments' => $this->getDoctrine()->getManager()->getRepository('ECLBlogBundle:Comment')->getAll()
            )
        );
    }

}
