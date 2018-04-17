<?php

namespace BDE\AccountBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AccountBundle\Form\LoginType;
use BDE\AccountBundle\Form\RegisterType;
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
            $session = $request->getSession();

            if ($user === NULL) {
                return $this->render('BDEAccountBundle:connection:login.html.twig', array(
                    'form' => $form->createView(),
                    'message' => 'Email ou mot de passe erroné!',
                    'name' => NULL,
                    ));
            }
            $idUser = $user->getId();
            //$idRole = $user->get
            $session->set('id', $idUser);

           /* if ( === 2){
                return $this->render('BDEAdminBundle::index.html.twig', array(
                    'message' => 'Vous êtes connecté!', 'name' => NULL,));
            }*/

            return $this->render('BDEAccountBundle::account.html.twig', array(
                'message' => 'Vous êtes connecté!', 'name' => NULL,));
        }

        return $this->render('BDEAccountBundle:connection:login.html.twig', array(
            'form' => $form->createView(), 'message' => '', 'name' => NULL,));
    }


    public function registerAction(Request $request)
    {


        $enquiry = new Users();
        $form = $this->createForm(RegisterType::class, $enquiry);
        $form->handleRequest($request);

        $enquiryManager = $this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            $password = $enquiry->getPassword();
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            if (!$uppercase || !$lowercase || !$number) {
                return $this->render('BDEAccountBundle:connection:register.html.twig', array(
                    'form' => $form->createView(),
                    'message' => 'Votre mot de passe doit contenir une majuscule et un chiffre!',
                    'name' => NULL,
                ));
            }

            $enquiry->setEmail($enquiry->getEmail())
                ->setName($enquiry->getName())
                ->setSurname($enquiry->getSurname())
                ->setPassword($enquiry->getPassword())
                ->initRole($enquiryManager);


            $enquiryManager->persist($enquiry);
            $enquiryManager->flush();

            return $this->render('BDEAccountBundle::account.html.twig', array(
                'message' => 'Félicitations',
                'name' => NULL,
            ));
        }

        return $this->render('BDEAccountBundle:connection:register.html.twig', array(
            'form' => $form->createView(),
            'name' => NULL,
            'message' => NULL,
        ));
    }

    public function disconnectAction(Request $request)
    {
        $session = $request->getSession();
        $session->set('id', 0);

        return $this->render('BDEAccountBundle::disconnect.html.twig', array(
            'name' => NULL,
        ));
    }


}
