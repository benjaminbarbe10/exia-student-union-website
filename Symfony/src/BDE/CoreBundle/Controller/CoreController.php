<?php

namespace BDE\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction()
    {
        return $this->render('BDECoreBundle::index.html.twig');
    }
}
