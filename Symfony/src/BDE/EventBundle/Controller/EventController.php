<?php

namespace BDE\EventBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EventController extends Controller
{
    public function eventsAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEEventBundle:Event:events.html.twig', array('name' => $userconnected));
    }

    public function viewEventAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEEventBundle:Event:viewEvent.html.twig', array('name' => $userconnected));
    }

    public function addEventAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEEventBundle:Event:addEvent.html.twig', array('name' => $userconnected));
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
