<?php
namespace ECL\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use ECL\ContactBundle\Form\Type\ContactType;

class DefaultController extends Controller
{
    
    public function submitAction()
    {
        $form = $this->createForm(new ContactType);
        $form->bind($this->getRequest());
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

            return $this->redirect($this->generateUrl('ecl_contact_info_'.$this->getLocale()));
        }

        return $this->redirect($this->generateUrl('ecl_contact_homepage_'.$this->getLocale()));
    }
    
    public function infoAction()
    {
        if (!$this->get('session')->has('email_sent')) {
            
            return $this->redirect($this->generateUrl('ecl_contact_homepage_'.$this->getLocale()));
        }
        $this->get('session')->remove('email_sent');

        return $this->render(
            'ECLContactBundle:Default:info.html.twig'
        );
    }

    public function indexAction()
    {
        $form = $this->createForm(new ContactType);

        return $this->render(
            'ECLContactBundle:Default:index.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    private function getLocale()
    {
        return $this->getRequest()->getLocale();
    }

}
