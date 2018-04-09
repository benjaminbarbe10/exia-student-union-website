<?php

namespace BDE\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{


    public function indexAction()
    {
        return $this->render('BDEShopBundle:Shop:index.html.twig');
    }

    public function cartAction()
    {
        return $this->render('BDEShopBundle:Shop:cart.html.twig');
    }


    public function articleAction($id)
    {
        $numPage = new Response("Affichage de l'annonce d'id : " . $id);

        return $this->render('BDEShopBundle:Shop:article.html.twig', array('numPage' => $numPage));
    }
}
