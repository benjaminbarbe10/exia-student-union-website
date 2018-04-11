<?php

namespace BDE\AccountBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AdminBundle\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\User;

class AccountController extends Controller
{
    public function loginAction()
    {
        return $this->render('BDEAccountBundle:connection:login.html.twig');
    }

    public function registerAction()
    {
        $user = new Users();
        $user->setName('BEN');
        $user->setSurname('Ten');
        $user->setPassword('test');
        $user->setEmail('Ben10@jpp.com');
        $em = $this->getDoctrine()->getManager();
        $user->initRole($em);






        $em->persist($user);
        $em->flush();

        return $this->render('BDEAccountBundle:connection:register.html.twig');
    }
}
