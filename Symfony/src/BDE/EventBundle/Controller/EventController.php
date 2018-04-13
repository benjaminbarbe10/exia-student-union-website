<?php

namespace BDE\EventBundle\Controller;


use BDE\AccountBundle\Entity\Users;

use BDE\EventBundle\Entity\Events;
use BDE\EventBundle\Entity\Events_picture;

use BDE\EventBundle\Repository\Events_pictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function eventsAction(Request $request)
    {

        $userconnected = $this->takeUserConnected($request);

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();


        return $this->render('BDEEventBundle:Event:events.html.twig', array(
            'listEvents' => $listEvents,
            'name' => $userconnected
        ));
    }

    public function viewEventAction($id, Request $request)
    {

       $userconnected = $this->takeUserConnected($request);

        $events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events')
            ->find($id);


        return $this->render('BDEEventBundle:Event:viewEvent.html.twig', array(
            'events' => $events,
            'name' => $userconnected
        ));
    }

    public function addEventAction(Request $request)
    {

        $events = new Events();
        $form = $this->createForm('BDE\EventBundle\Form\EventsType', $events);

        $form->handleRequest($request);
        $userconnected = $this->takeUserConnected($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $events->getEvents_picture();
            if ($attachments) {
                foreach($attachments as $attachment)
                {
                    $file = $attachment->getPicture();

                    $filename = md5(uniqid()) . '.' .$file->guessExtension();

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
            'name' => $userconnected
        ));
    }

    public function editEventAction(Request $request)
    {

        return $this->render('BDEEventBundle:Event:edit.html.twig', array('name' => $userconnected));


    }

    public function viewSuggestionAction(Request $request)

    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEEventBundle:Event:viewSuggestion.html.twig', array('name' => $userconnected));
    }


    public function suggestionAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEEventBundle:Event:suggestion.html.twig', array('name' => $userconnected));
    }


    public function takeUserConnected(Request $request)
    {
            $session = $request->getSession();
            //$session->set('id', 2);
            $id = $session->get('id');
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->find($id);
            //var_dump($user); die;
            if ($id != 0) {
                $userconnected = $user->getName();
            }
            else {
                $userconnected = '';
            }

            return $userconnected;
        }

}
