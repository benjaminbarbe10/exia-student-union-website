<?php

namespace BDE\ContactBundle\Controller;

use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryType::class, $enquiry);

        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $message = \Swift_Message::newInstance()

                ->setSubject($enquiry->getSubject())
                ->setFrom($enquiry->getEmail())
                ->setTo('bdecesi@laposte.net')
                ->setBody($enquiry->getBody());

            $this->get('mailer')->send($message);

            return $this->render('BDECoreBundle::index.html.twig', array(
                'form' => $form->createView(),));

        }

        return $this->render('BDEContactBundle::contact.html.twig', array(
            'form' => $form->createView(),));

    }
}

