<?php

namespace BDE\EventBundle\Controller;

use BDE\EventBundle\Entity\Events;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


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

    public function addEventAction(Request $request)
    {
        $event = new Events();
//set approved =  1 car cette page uniquement dispo pour les membres du BDE (ducoup iils sont ajoutés directement dans la page des events!
        $event->setIsApproved(1);

        $form = $this->get('form.factory')->createBuilder(FormType::class, $event)
            ->add('name',       TextType::class)
            ->add('date',       DateType::class)
            ->add('place',      TextType::class)
            ->add('description',TextareaType::class)
            ->add('pricettc',   NumberType::class)
            ->add('type',       TextType::class)
            ->add('save',       SubmitType::class)
            ->getForm();
        ;


        // Si la requête est en POST
        if ($request->isMethod('POST')) {

            $form->handleRequest($request);


            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Event bien enregistrée.');

                return $this->redirectToRoute('bde_event_viewevent', array('id' => $event->getId()));
            }
        }
        return $this->render('BDEEventBundle:Event:addEvent.html.twig',array(
            'form' => $form->createView(),
        ));
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
