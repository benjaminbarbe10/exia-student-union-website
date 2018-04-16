<?php

namespace BDE\ShopBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\ShopBundle\Entity\Cart;
use BDE\ShopBundle\Form\ArticleType;
use BDE\ShopBundle\Form\CartType;
use BDE\ShopBundle\Entity\Articles;
use PDO;
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
        $id = $session->get('id');
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);
        if ($id != 0) {
            $userconnected = $user->getName();
        } else {
            $userconnected = '';
        }

        return $userconnected;
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
        $form = $this->createForm(ArticleType::class, $enquiry);
        $form->handleRequest($request);

        $userconnected = $this->takeUserConnected($request);

        if ($request->isMethod('POST')) {
            $enquiry->setArticles($article);
            $enquiry->setUsers($user);
            $enquiry->setQuantity(1);

            $entiyManager = $this->getDoctrine()->getManager();
            $entiyManager->persist($enquiry);
            $entiyManager->flush();

            return $this->cartAction($request);
        }

        return $this->render('BDEShopBundle:Shop:article.html.twig', array(
            'form' => $form->createView(),
            'name' => $userconnected,
            'article' => $article,
        ));
    }

    public function cartAction(Request $request)
    {

        $userconnected = $this->takeUserConnected($request);
        $session = $request->getSession();
        $id = $session->get('id');

        $enquiry = new Cart();
        $form = $this->createForm(CartType::class, $enquiry);
        $form->handleRequest($request);

        $em = $this->getDoctrine()->getManager();
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
            'form' => $form->createView(),
            'name' => $userconnected,
            'articles' => $cart,
        ));
    }

    public function commandAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        $session = $request->getSession();
        $id = $session->get('id');
        $bdd = new PDO('mysql:host=localhost;dbname=bdecesi;charset=utf8', 'root', '');

        if ($request->isMethod('POST')) {

            $this->createOrder($id, $bdd);
            $results = $this->takeNewOrder($id);
            $this->CartFromOrder($id, $bdd, $results);
            $this->deleteCart($id, $bdd);

        }

        return $this->render('BDECoreBundle::index.html.twig', array(
            'name' => $userconnected
        ));
    }

    public function createOrder($id, $bdd)
    {
        $time = date('H:i:s d:m:Y');

        $requete = $bdd->prepare("INSERT INTO orders (users_id, date_order) VALUES( :users_id,:date_order)");
        $requete->bindValue(':users_id', $id, PDO::PARAM_STR);
        $requete->bindValue(':date_order', $time, PDO::PARAM_STR);
        $requete->execute();
    }

    public function takeNewOrder($id)
    {
        $em = $this->getDoctrine()->getManager();
        $sql = "
        SELECT max(id) as total
        FROM orders
        WHERE users_id = " . $id;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute();
        (int)$results = $stmt->fetchAll();

        return $results;
    }

    private function CartFromOrder($id, $bdd, $results)
    {
        foreach ($results as $result) {
            $idorder = (int)$result['total'];

            $em = $this->getDoctrine()->getManager();
            $sql = "
        SELECT articles_id as total
        FROM cart
        WHERE users_id = " . $id;

            $stmt = $em->getConnection()->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll();


            foreach ($results as $result) {
                $idarticle = (int)$result['total'];
                $article = $this->getDoctrine()
                    ->getRepository(Articles::class)
                    ->find($idarticle);

                $requete = $bdd->prepare("INSERT INTO orders_line (orders_id, articles_id, quantity, unitypricettc, articlename) VALUES( :orders_id,:articles_id,:quantity,:unitypricettc,:articlename)");
                $requete->bindValue(':orders_id', $idorder, PDO::PARAM_STR);
                $requete->bindValue(':articles_id', $article->getId(), PDO::PARAM_STR);
                $requete->bindValue(':articlename', $article->getName(), PDO::PARAM_STR);
                $requete->bindValue(':unitypricettc', $article->getPriceTTC(), PDO::PARAM_STR);
                $requete->bindValue(':quantity', 1, PDO::PARAM_STR);
                $requete->execute();
            }
        }

    }

    private function deleteCart($id, $bdd)
    {
        $requete = $bdd->prepare("DELETE FROM cart WHERE users_id = $id");
        $requete->execute();
    }

}
