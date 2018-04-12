<?php

namespace BDE\CoreBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CoreController extends Controller
{
    public function indexAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDECoreBundle::index.html.twig', array(
            'name' => $userconnected
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
        } else {
            $userconnected = '';
        }

        return $userconnected;

    }
}
