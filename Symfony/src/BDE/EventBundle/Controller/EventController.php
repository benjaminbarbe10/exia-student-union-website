<?php

namespace BDE\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EventController extends Controller
{
    public function eventsAction()
    {
        return $this->render('BDEEventBundle:Event:events.html.twig');
    }

    public function viewEventAction()
    {
        return $this->render('BDEEventBundle:Event:viewEvent.html.twig');
    }

    public function addEventAction()
    {
        return $this->render('BDEEventBundle:Event:addEvent.html.twig');
    }

    public function viewSuggestionAction()
    {
        return $this->render('BDEEventBundle:Event:viewSuggestion.html.twig');
    }

    public function suggestionAction()
    {
        return $this->render('BDEEventBundle:Event:suggestion.html.twig');
    }

}
