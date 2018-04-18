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
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        if ($request->isMethod('POST')) {
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->findOneBy(array('email' => $enquiry->getEmail(), 'password' => $enquiry->getPassword()));
            $session = $request->getSession();


            if ($user === NULL) {
                return $this->render('BDEAccountBundle:connection:login.html.twig', array(
                    'formconnect' => $formconnect->createView(),
                    'formregister' => $formregister->createView(),
                    'message' => 'Email ou mot de passe erroné!',
                    'name' => NULL,
                ));
            }

            $idUser = $user->getId();
            $session->set('id', $idUser);

            $id = $session->get('id');
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->find($id);
            if ($id != 0) {
                $userconnected = $user->getName();
            } else {
                $userconnected = '';
            }

            return $this->render('BDECoreBundle::index.html.twig', array(
                'formconnect' => $formconnect->createView(),
                'formregister' => $formregister->createView(),
                'name' => $userconnected,
            ));
        }

        return $this->render('BDEAccountBundle:connection:login.html.twig', array(
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
            'message' => '',
            'name' => NULL,));
    }


    public function registerAction(Request $request)
    {


        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $enquiryManager = $this->getDoctrine()->getManager();


        if ($request->isMethod('POST')) {
            $password = $enquiry->getPassword();
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number = preg_match('@[0-9]@', $password);
            if (!$uppercase || !$lowercase || !$number) {
                return $this->render('BDEAccountBundle:connection:register.html.twig', array(
                    'formconnect' => $formconnect->createView(),
                    'formregister' => $formregister->createView(),
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
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
            'name' => NULL,
            'message' => NULL,
        ));
    }

    public function disconnectAction(Request $request)
    {
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $session = $request->getSession();
        $session->set('id', 0);

        return $this->render('BDECoreBundle::index.html.twig', array(
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
            'name' => NULL,
        ));
    }


}
