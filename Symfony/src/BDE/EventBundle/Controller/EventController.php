<?php

namespace BDE\EventBundle\Controller;


use BDE\AccountBundle\Entity\Users;


use BDE\AccountBundle\Form\LoginType;
use BDE\AccountBundle\Form\RegisterType;
use BDE\EventBundle\Entity\Events;
use BDE\EventBundle\Entity\Events_picture;

use BDE\EventBundle\Form\EventsType;
use BDE\EventBundle\Repository\Events_pictureRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function eventsAction(Request $request)
    {

        $userconnected = $this->takeUserConnected($request);

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();


        return $this->render('BDEEventBundle:Event:events.html.twig', array(
            'listEvents' => $listEvents,
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function viewEventAction(Events $events, Request $request)
    {


       $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);


        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();
        return $this->render('BDEEventBundle:Event:viewEvent.html.twig', array(
            'events' => $events,
            'name' => $userconnected,
            'listEvents' => $listEvents,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }


    public function addSuggestionAction(Request $request)
    {

        $events = new Events();
        $form = $this->createForm('BDE\EventBundle\Form\EventsType', $events);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();


        $form->handleRequest($request);
        $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $events->getEvents_picture();
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getPicture();

                    $filename = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                        $this->getParameter('upload_path'), $filename
                    );
                    $attachment->setPicture($filename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();

            return $this->redirectToRoute('bde_event_index');
        }

        return $this->render('BDEEventBundle:Event:addSuggestion.html.twig', array(
            'events' => $events,
            'form' => $form->createView(),
            'listEvents' => $listEvents,
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function addEventAction(Request $request)
    {

        $events = new Events();
        $form = $this->createForm('BDE\EventBundle\Form\EventsType', $events);
        $events->setUsers($this->getUser());

        $form->handleRequest($request);
        $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();
        $events->setIsApproved(1);

        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $events->getEvents_picture();
            if ($attachments) {
                foreach ($attachments as $attachment) {
                    $file = $attachment->getPicture();

                    $filename = md5(uniqid()) . '.' . $file->guessExtension();

                    $file->move(
                        $this->getParameter('upload_path'), $filename
                    );
                    $attachment->setPicture($filename);
                }
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();

            return $this->redirectToRoute('bde_event_viewevent', array('id' => $events->getId()));
        }

        return $this->render('BDEEventBundle:Event:addEvent.html.twig', array(
            'events' => $events,
            'form' => $form->createView(),
            'listEvents' => $listEvents,
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function editEventAction($id, Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('BDEEventBundle:Events')->find($id);
        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $events);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();

        $formBuilder
            ->add('name', TextType::class)

            ->add('description', TextareaType::class)
            ->add('place', TextType::class)

            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Ponctuelle' => 'ponctuelle',
                    'Mensuel' => 'mensuel'
                )
            ))
            ->add('pricettc', NumberType::class)
            ->add('save', SubmitType::class)


        ;


        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();

            return $this->redirectToRoute('bde_event_viewevent', array('id' => $events->getId()));
        }



        return $this->render('BDEEventBundle:Event:addEvent.html.twig', array(
            'events' => $events,
            'form' => $form->createView(),
            'listEvents' => $listEvents,
            'name' => $userconnected
        ));

    }

    public function deleteEventAction($id, Request $request)
    {
        $userconnected = $this->takeUserConnected($request);

        $em = $this->getDoctrine()->getManager();

        $events = $em->getRepository('BDEEventBundle:Events')->find($id);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();

        $em = $this->getDoctrine()->getManager();

        $form = $this->get('form.factory')->create();
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->remove($events);
            $em->flush();
            $request->getSession()->getFlashBag()->add('info', "L'event a bien été supprimé.");
            return $this->redirectToRoute('bde_event_index');
        }

        return $this->render('BDEEventBundle:Event:delete.html.twig', array(
            'event' => $events,
            'form'   => $form->createView(),
            'name' => $userconnected,
            'listEvents' => $listEvents,


        ));
    }

    public function viewSuggestionAction(Request $request)

    {
        $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);
        return $this->render('BDEEventBundle:Event:viewSuggestion.html.twig', array(
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }


    public function suggestionAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);
        return $this->render('BDEEventBundle:Event:suggestion.html.twig', array(
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
            }
            else {
                $userconnected = '';
            }

            return $userconnected;

        }

        return $userconnected;
    }

}
