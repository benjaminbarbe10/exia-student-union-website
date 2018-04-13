<?php

namespace BDE\ShopBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{


    public function indexAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEShopBundle:Shop:index.html.twig', array(
            'name' => $userconnected,
        ));
    }

    public function cartAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEShopBundle:Shop:cart.html.twig', array(
            'name' => $userconnected,
        ));
    }


    public function articleAction($id, Request $request)
    {
        $numPage = new Response("Affichage de l'annonce d'id : " . $id);

        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEShopBundle:Shop:article.html.twig', array(
            'numPage' => $numPage,
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
