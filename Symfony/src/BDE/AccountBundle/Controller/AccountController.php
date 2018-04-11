<?php

namespace BDE\AccountBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AccountBundle\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AccountController extends Controller
{
    public function loginAction(Request $request)
    {
        $enquiry = new Users();
        $form = $this->createForm(LoginType::class, $enquiry);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findOneBy(array('email' => $enquiry->getEmail(), 'password' => $enquiry->getPassword()));

            if ($user === NULL) {
                return $this->render('BDEAccountBundle:connection:login.html.twig', array(
                    'form' => $form->createView(), 'message' => 'Email ou mot de passe erroné!',));
            }

            return $this->render('BDEAccountBundle::account.html.twig', array(
                'message' => 'Vous êtes connecté!',));
        }

        return $this->render('BDEAccountBundle:connection:login.html.twig', array(
            'form' => $form->createView(),'message' => '',));
    }




    public function registerAction()
    {



       /*$user = new Users();
        $user->setName('BEN');
        $user->setSurname('Ten');
        $user->setPassword('test');
        $user->setEmail('Ben10@jpp.com');
        $em = $this->getDoctrine()->getManager();
        $user->initRole($em);


        $em->persist($user);
        $em->flush();*/

        return $this->render('BDEAccountBundle:connection:register.html.twig');
    }
}
