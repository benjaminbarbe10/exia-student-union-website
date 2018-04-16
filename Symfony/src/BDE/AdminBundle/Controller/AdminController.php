<?php

namespace BDE\AdminBundle\Controller;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BDE\AccountBundle\Entity\Users;
use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdminController extends Controller
{
public function AdminAction(Request $request){

$role = $this->getDoctrine()->getManager()->getRepository('BDEAdminBundle:Role')->findAll();
    $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('BDEAccountBundle:Users');
    $listUsers = $repository->findBy(array('role' => $role));
    $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('BDEEventBundle:Events');
    $listEvents = $repository->findAll();


    $userconnected = $this->takeUserConnected($request);
    return $this->render('BDEAdminBundle:admin:index.html.twig', array(
        'name' => $userconnected,
        'listUsers' => $listUsers,
        'listEvents' => $listEvents,
    ));
}

public function viewUserAction($id, Request $request){

    $userconnected = $this->takeUserConnected($request);




    $em = $this->getDoctrine()->getManager();
    $user = $em->getRepository('BDEAccountBundle:Users')->find($id);



    $role = $user->getRole();


    $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

    $formBuilder
        ->add('role', EntityType::class, array(
                'class'        => 'BDEAdminBundle:Role',
                'choice_label' => 'name',
            ))
        ->add('name', TextType::class)
        ->add('surname', TextType::class)

        ->add('email', EmailType::class)
        ->add('save',      SubmitType::class)

    ;
    $form = $formBuilder->getForm();
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {


        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('bde_admin_viewuser', array('id' => $user->getId()));
    }

    return $this->render('BDEAdminBundle:admin:viewUser.html.twig', array(
        'user' => $user,
        'name' => $userconnected,
        'role' => $role,
        'form' => $form->createView(),


    ));



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
