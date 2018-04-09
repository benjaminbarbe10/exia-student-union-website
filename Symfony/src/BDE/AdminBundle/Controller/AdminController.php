<?php

namespace BDE\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('BDEAdminBundle::index.html.twig');
    }
}
