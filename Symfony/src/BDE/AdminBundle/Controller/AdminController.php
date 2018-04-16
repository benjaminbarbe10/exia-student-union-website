<?php

namespace BDE\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BDE\AccountBundle\Entity\Users;
use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
public function AdminAction(Request $request){
    $userconnected = $this->takeUserConnected($request);
    return $this->render('BDEAdminBundle::index.html.twig', array(
        'name' => $userconnected,
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
