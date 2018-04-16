<?php

namespace BDE\ShopBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\ShopBundle\Entity\Cart;
use BDE\ShopBundle\Form\CartType;
use BDE\ShopBundle\Entity\Articles;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
                'description' => $article->getDescription(),
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
        $session = $request->getSession();
        $id = $session->get('id');

        $em = $this->getDoctrine()->getManager();
        echo ",   ";
        $sql = "
        SELECT articles_id as total
        FROM cart
        WHERE users_id = " . $id;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        $cart = array();

        foreach ($results as $result) {
            $idarticle = (int)$result['total'];
            $article = $this->getDoctrine()
                ->getRepository(Articles::class)
                ->find($idarticle);
            $cart[$article->getId()] = [
                'name' => $article->getName(),

            ];
        }

        return $this->render('BDEShopBundle:Shop:cart.html.twig', array(
            'name' => $userconnected,
            'articles' => $cart,
        ));
    }

    public function articleAction($id, Request $request)
    {
        $article = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->find($id);
        $session = $request->getSession();
        $id = $session->get('id');
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);

        $enquiry = new Cart();
        $form = $this->createForm(CartType::class, $enquiry);
        $form->handleRequest($request);

        $userconnected = $this->takeUserConnected($request);

        if ($request->isMethod('POST')) {
            $enquiry->setArticles($article);
            $enquiry->setUsers($user);
            $enquiry->setQuantity(1);

            $entiyManager = $this->getDoctrine()->getManager();
            $entiyManager->persist($enquiry);
            $entiyManager->flush();

            /*return $this->render('BDEAccountBundle::account.html.twig', array(
                'message' => 'Article ajouté!', 'name' => NULL,));*/
            return $this->cartAction($request);
        }

        return $this->render('BDEShopBundle:Shop:article.html.twig', array(
            'form' => $form->createView(),
            'name' => $userconnected,
            'article' => $article,
        ));
    }

}
