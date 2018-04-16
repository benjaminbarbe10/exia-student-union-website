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


        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $eventlist = $repository->findAll();

        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDECoreBundle::index.html.twig', array(
            'name' => $userconnected,
            'listUsers' => $eventlist,
        ));
    }


    public function takeUserConnected(Request $request)
    {
        $session = $request->getSession();
        $id = $session->get('id');

        if ($id != NULL) {
            $user = $this->getDoctrine()
                ->getRepository(Users::class)
                ->find($id);
        } else {
            $session->set('id', 0);
        }
            //var_dump($user); die;
            if ($id != 0) {
                $userconnected = $user->getName();
            } else {
                $userconnected = '';
            }


        return $userconnected;

    }
}
