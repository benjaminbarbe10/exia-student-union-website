<?php

namespace BDE\AdminBundle\Controller;


use BDE\EventBundle\Form\Events_pictureType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use BDE\EventBundle\Entity\Events;
use BDE\ShopBundle\Entity\Articles;
use BDE\AdminBundle\Form\NewArticleType;
use PDO;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use BDE\AccountBundle\Entity\Users;
use BDE\ContactBundle\Entity\Enquiry;
use BDE\ContactBundle\Form\EnquiryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class AdminController extends Controller
{
    public function AdminAction(Request $request)
    {
        $role = $this->getDoctrine()->getManager()->getRepository('BDEAdminBundle:Role')->findAll();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEAccountBundle:Users');
        $listUsers = $repository->findBy(array('role' => $role));
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEEventBundle:Events');
        $listEvents = $repository->findAll();
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('BDEShopBundle:Articles');
        $listArticles = $repository->findAll();

        $userconnected = $this->takeUserConnected($request);
        $roleconnected = $this->takeRoleConnected($request);

        return $this->render('BDEAdminBundle:admin:index.html.twig', array(
            'name' => $userconnected,
            'listUsers' => $listUsers,
            'listEvents' => $listEvents,
            'listArticles' => $listArticles,
            'roleconnect' => $roleconnected,
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

    public function takeRoleConnected(Request $request)
    {
        $session = $request->getSession();
        //$session->set('id', 2);
        $id = $session->get('id');
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($id);
        //var_dump($user); die;
        if ($id != 0) {
            $userconnected = $user->getRole();
            $roleconnected = $userconnected->getId();
        } else {
            $roleconnected = '';
        }

        return $roleconnected;
    }

    public function viewArticleAction($id, Request $request)
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdecesi;charset=utf8', 'root', '');

        $userconnected = $this->takeUserConnected($request);
        $roleconnected = $this->takeRoleConnected($request);

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BDEAccountBundle:Users')->find($id);
        $article = $em->getRepository('BDEShopBundle:Articles')->find($id);
        $role = NULL; //$user->getRole();

        if ($request->isMethod('POST')) {

            $requete = $bdd->prepare("DELETE FROM articles WHERE id = $id");
            $requete->execute();

            return $this->redirectToRoute('bde_admin_index', array('id' => $user->getId()));
        }

        return $this->render('BDEAdminBundle:admin:viewArticle.html.twig', array(
            'article' => $article,
            'name' => $userconnected,
            'role' => $role,
            'roleconnect' => $roleconnected,
        ));


    }

    public function viewUserAction($id, Request $request)
    {

        $userconnected = $this->takeUserConnected($request);
        $roleconnected = $this->takeRoleConnected($request);


        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BDEAccountBundle:Users')->find($id);


        $role = $user->getRole();


        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $user);

        $formBuilder
            ->add('role', EntityType::class, array(
                'class' => 'BDEAdminBundle:Role',
                'choice_label' => 'name',
            ))
            ->add('name', TextType::class)
            ->add('surname', TextType::class)
            ->add('email', EmailType::class)
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('bde_admin_viewuser', array('id' => $user->getId()));
        }

        return $this->render('BDEAdminBundle:admin:viewUser.html.twig', array(
            'user' => $user,
            'name' => $userconnected,
            'role' => $role,
            'form' => $form->createView(),
            'roleconnect' => $roleconnected,
        ));


    }

    public function newArticleAction(Request $request)
    {
        $userconnected = $this->takeUserConnected($request);
        $roleconnected = $this->takeRoleConnected($request);

        $article = new Articles();
        $form = $this->createForm(NewArticleType::class, $article);
        $form->handleRequest($request);

        if ($request->isMethod('POST')) {

            $file = $article->getPicture();

            $filename = $file->getClientOriginalName();
            $picture = "upload/" . $filename;
            $file->move(
                $this->getParameter('upload_path'), $filename
            );

            $article->setPicture($picture);

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('bde_shop_index');
        }

        return $this->render('BDEAdminBundle:admin:addarticle.html.twig', array(
            'name' => $userconnected,
            'form' => $form->createView(),
            'roleconnect' => $roleconnected,
        ));

    }


    public
    function viewSuggestionAction($id, Request $request)
    {

        $userconnected = $this->takeUserConnected($request);


        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('BDEEventBundle:Events')->find($id);


        $formBuilder = $this->get('form.factory')->createBuilder(FormType::class, $events);

        $formBuilder
            ->add('date', DateType::class)
            ->add('name', TextType::class)
            ->add('description', TextareaType::class)
            ->add('place', TextType::class)
            ->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Ponctuelle' => 'ponctuelle',
                    'Mensuel' => 'mensuel'
                )
            ))
            ->add('pricettc', NumberType::class)
            ->add('save', SubmitType::class);
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $events->setIsApproved(1);

            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();

            return $this->redirectToRoute('bde_event_viewevent', array('id' => $events->getId()));
        }

        return $this->render('BDEAdminBundle:admin:viewSuggestion.html.twig', array(
            'events' => $events,
            'name' => $userconnected,
            'form' => $form->createView(),


        ));


    }

}

