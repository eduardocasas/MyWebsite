<?php

namespace AppBundle\Controller\contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\contact\ContactType;

class DefaultController extends Controller
{
    
    public function submitAction(Request $request)
    {
        $form = $this->createForm(new ContactType);
        $form->bind($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
            ->setSubject($data['subject'])
            ->setFrom($this->container->getParameter('my_email_1'))
            ->setTo($this->container->getParameter('my_email'))
            ->setBody('Correo enviado desde la web www.eduardocasas.com
                    
nombre: '.$data['name'].'
    
email: '.$data['email'].'
                    
'.$data['message']);
            $this->get('mailer')->send($message);
            $this->get('session')->set('email_sent', true);

            return $this->redirect($this->generateUrl('contact_info_'.$request->getLocale()));
        }

        return $this->redirect($this->generateUrl('contact_'.$request->getLocale()));
    }
    
    public function infoAction(Request $request)
    {
        if (!$this->get('session')->has('email_sent')) {
            
            return $this->redirect($this->generateUrl('contact_'.$request->getLocale()));
        }
        $this->get('session')->remove('email_sent');

        return $this->render('contact/info.html.twig');
    }

    public function indexAction()
    {
        $form = $this->createForm(new ContactType);

        return $this->render('contact/index.html.twig', ['form' => $form->createView()]);
    }
    
}
