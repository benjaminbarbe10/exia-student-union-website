<?php

namespace BDE\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    public function indexAction()
    {
        return $this->render('BDEContactBundle::contact.html.twig');
    }
}
