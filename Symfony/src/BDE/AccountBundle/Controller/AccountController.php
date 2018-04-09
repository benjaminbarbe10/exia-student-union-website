<?php

namespace BDE\AccountBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccountController extends Controller
{
    public function loginAction()
    {
        return $this->render('BDEAccountBundle:connection:login.html.twig');
    }

    public function registerAction()
    {
        return $this->render('BDEAccountBundle:connection:register.html.twig');
    }
}
