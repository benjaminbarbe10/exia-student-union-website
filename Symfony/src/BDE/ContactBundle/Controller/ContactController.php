<?php

namespace BDE\ContactBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AccountBundle\Form\LoginType;
use BDE\AccountBundle\Form\RegisterType;
use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryType::class, $enquiry);
        $form->handleRequest($request);
        $userconnected = $this->takeUserConnected($request);

        if ($request->isMethod('POST')) {
            $message = \Swift_Message::newInstance()
                ->setSubject($enquiry->getSubject())
                ->setFrom($enquiry->getEmail())
                ->setTo('bdecesi@laposte.net')
                ->setBody($enquiry->getBody());
            $this->get('mailer')->send($message);
            return $this->render('BDECoreBundle::index.html.twig', array(
                'form' => $form->createView(),
                'name' => $userconnected,
                'formconnect' => $formconnect->createView(),
                'formregister' => $formregister->createView(),
            ));

        }

        return $this->render('BDEContactBundle::contact.html.twig', array(
            'form' => $form->createView(),
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }


    public function takeUserConnected(Request $request)
    {
        $session = $request->getSession();
        $id = $session->get('id');
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);
        if ($id != 0) {
            $userconnected = $user->getName();
        } else {
            $userconnected = '';
        }

        return $userconnected;
    }
}
