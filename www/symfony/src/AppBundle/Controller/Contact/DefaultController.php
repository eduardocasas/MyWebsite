<?php

namespace AppBundle\Controller\Contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\Type\Contact\ContactType;

class DefaultController extends Controller
{
    public function submitAction(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $message = \Swift_Message::newInstance()
            ->setSubject($this->container->getParameter('mailer_prefix_site').'Correo enviado desde la web')
            ->setFrom($this->container->getParameter('mailer_user'))
            ->setTo($this->container->getParameter('mailer_user'))
            ->setBody('Nombre: '.$data['name'].'

Email: '.$data['email'].'
    
Asunto: '.$data['subject'].'

Mensaje:

'.$data['message']);
            file_put_contents(
                $this->container->getParameter('kernel.logs_dir').'/email/'.date('Y-m-d').'.log',
                "\n".$message->getHeaders()->toString()."\n".$message->getBody(),
                FILE_APPEND
            );
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
        return $this->render('contact/index.html.twig', [
            'form' => $this->createForm(ContactType::class)->createView(),
        ]);
    }
}
