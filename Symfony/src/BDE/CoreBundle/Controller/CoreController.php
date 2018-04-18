<?php

namespace BDE\CoreBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AccountBundle\Form\LoginType;
use BDE\AccountBundle\Form\RegisterType;
use BDE\ShopBundle\Entity\Articles;
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

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        return $this->render('BDECoreBundle::index.html.twig', array(
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
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
