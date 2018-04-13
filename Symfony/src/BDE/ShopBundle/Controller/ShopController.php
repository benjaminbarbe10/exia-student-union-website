<?php

namespace BDE\ShopBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\ShopBundle\Entity\Articles;
use BDE\ShopBundle\Entity\Orders_line;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ShopController extends Controller
{


    public function indexAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);

        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findAll();

        $count = array();
        $em = $this->getDoctrine()->getManager();


        foreach ($articles as $article) {
            $sql = " 
        SELECT sum(Quantity) as total
        FROM orders_line
        WHERE articles_id = " . $article->getId();

            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch();
            $count[$article->getId()] = [
                'total' => $result['total'],
                'id' => $article->getId(),
                'name' => $article->getName(),
                'price' => $article->getPriceTTC(),
                'picture' => $article->getPicture(),
            ];

        }
        arsort($count);

        return $this->render('BDEShopBundle:Shop:index.html.twig', array(
            'name' => $userconnected,
            'articles' => $articles,
            'toparticle' => $count,
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
        $article = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);

        $userconnected = $this->takeUserConnected($request);
        return $this->render('BDEShopBundle:Shop:article.html.twig', array(
            'numPage' => $numPage,
            'name' => $userconnected,
            'article' => $article,
        ));
    }
}
