<?php

namespace BDE\ShopBundle\Controller;

use BDE\AccountBundle\Entity\Users;
use BDE\AccountBundle\Form\LoginType;
use BDE\AccountBundle\Form\RegisterType;
use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
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

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

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
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function tribyletterAction(Request $request){
        $userconnected = $this->takeUserConnected($request);

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findAll();

        $tribyletter = array();

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
            $tribyletter[$article->getId()] = [
                'name' => $article->getName(),
                'priceTTC' => $article->getPriceTTC(),
                'picture' => $article->getPicture(),
                'description' => $article->getDescription(),
                'id' => $article->getId(),
            ];

        }
        arsort($count);
        sort($tribyletter);

        return $this->render('BDEShopBundle:Shop:index.html.twig', array(
            'name' => $userconnected,
            'articles' => $tribyletter,
            'toparticle' => $count,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function tribypriceAction(Request $request){
        $userconnected = $this->takeUserConnected($request);

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $articles = $this->getDoctrine()
            ->getRepository(Articles::class)
            ->findAll();

        $tribyprice = array();

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
            $tribyprice[$article->getId()] = [
                'priceTTC' => $article->getPriceTTC(),
                'name' => $article->getName(),
                'picture' => $article->getPicture(),
                'description' => $article->getDescription(),
                'id' => $article->getId(),
            ];

        }
        arsort($count);
        sort($tribyprice);

        return $this->render('BDEShopBundle:Shop:index.html.twig', array(
            'name' => $userconnected,
            'articles' => $tribyprice,
            'toparticle' => $count,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
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

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

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
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function cartAction(Request $request)
    {

        $userconnected = $this->takeUserConnected($request);
        $session = $request->getSession();
        $id = $session->get('id');

        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

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
                'id' => $article->getId(),
                'name' => $article->getName(),
                'price' => $article->getPriceTTC(),
                'picture' => $article->getPicture(),
                'description' => $article->getDescription(),
            ];
        }

        return $this->render('BDEShopBundle:Shop:cart.html.twig', array(
            'form' => $form->createView(),
            'name' => $userconnected,
            'articles' => $cart,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
        ));
    }

    public function commandAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        $session = $request->getSession();
        $id = $session->get('id');
        $enquiry = new Users();
        $formconnect = $this->createForm(LoginType::class, $enquiry);
        $formconnect->handleRequest($request);
        $formregister = $this->createForm(RegisterType::class, $enquiry);
        $formregister->handleRequest($request);

        $bdd = new PDO('mysql:host=localhost;dbname=bdecesi;charset=utf8', 'root', '');

        if ($request->isMethod('POST')) {

            $this->createOrder($id, $bdd);
            $results = $this->takeNewOrder($id);
            $this->cartFromOrder($id, $bdd, $results);
            $this->deleteCart($id, $bdd);
            $this->sendMail($request, $id, $userconnected);

        }

        return $this->render('BDECoreBundle::index.html.twig', array(
            'name' => $userconnected,
            'formconnect' => $formconnect->createView(),
            'formregister' => $formregister->createView(),
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

    private function cartFromOrder($id, $bdd, $results)
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

    private function sendMail($request, $id, $userconnected)
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(EnquiryType::class, $enquiry);
        $form->handleRequest($request);

        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);
        $mailconnected = $user->getEmail();

        $message = \Swift_Message::newInstance()
            ->setSubject('Nouvelle Commande')
            ->setFrom($mailconnected)
            ->setTo('bdecesi@laposte.net')
            ->setBody("C'est la commande de l'utilisateur: $userconnected!");
        $this->get('mailer')->send($message);

        $confirm = \Swift_Message::newInstance()
            ->setSubject('Commande confirmée')
            ->setFrom('bdecesi@laposte.net')
            ->setTo($mailconnected)
            ->setBody("Votre commande a été prise en charge! Vous recevrez un mail plus complet sous peu... Cordialement, le BDE.");
        $this->get('mailer')->send($confirm);

    }

}
