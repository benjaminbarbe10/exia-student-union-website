<?php

namespace BDE\EventBundle\Controller;

use BDE\EventBundle\BDEEventBundle;
use BDE\EventBundle\Entity\Events;
use BDE\EventBundle\Entity\Events_picture;

use BDE\EventBundle\Repository\Events_pictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;


class EventController extends Controller
{
    public function eventsAction()
    {

        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();


        return $this->render('BDEEventBundle:Event:events.html.twig', array(
            'listEvents' => $listEvents
        ));
    }

    public function viewEventAction($id)
    {
        $events = $this->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events')
            ->find($id);


        return $this->render('BDEEventBundle:Event:viewEvent.html.twig', array(
            'events' => $events
        ));
    }

    public function addEventAction(Request $request)
    {
        $events = new Events();
        $form = $this->createForm('BDE\EventBundle\Form\EventsType', $events);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $attachments = $events->getEvents_picture();
            if ($attachments) {
                foreach($attachments as $attachment)
                {
                    $file = $attachment->getPicture();

                    var_dump($attachment);
                    $filename = md5(uniqid()) . '.' .$file->guessExtension();

                    $file->move(
                        $this->getParameter('upload_path'), $filename
                    );
                    var_dump($filename);
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
        ));
    }

    public function editEventAction(Request $request)
    {

        return $this->render('BDEEventBundle:Event:edit.html.twig');


    }

    public
    function viewSuggestionAction()
    {
        return $this->render('BDEEventBundle:Event:viewSuggestion.html.twig');
    }

    public
    function suggestionAction()
    {
        return $this->render('BDEEventBundle:Event:suggestion.html.twig');
    }





}
