<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Promo;
use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Form\PromoType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Repository\PromoRepository;
use App\Repository\UserRepository;
use App\Service\Panier\PanierService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;



class AdminController extends AbstractController
{


    /**
     * @Route("/ajout_article",name="ajout_article")
     */
    public function ajout_article(Request $request, EntityManagerInterface $manager)
    {
        //ici cette fonction a pour but d'afficher le formulaire d'ajout et de traiter le formulaire si envoyé.
        //Lors d'une reception de données de type POST, GET ,FILE, COOKIE, Request (de httpfoundation) doit être appelé, en effet c'est lui qui receptionne toutes les informations de nos superglobales.
        //Lors d'une modification en BDD (insertion, modification ou suppression ), le manager d'entityManagerInterface (de l'ORM Doctrine) doit systématiquement être appelé

        $article= new Article(); //ici on instancie un objet Article vide
        //que l'on va charger avec les informations réceptionnées du formulaire grace à Request

        $form=$this->createForm(ArticleType::class,$article, array('ajouter'=>true) );
        // ici on instancie un objet Form qui va controller automatiquement la correspondance des champs de formulaire demandés dans ArticleType avec les propriétés de notre entité article.
        //La méthode createForm() attent 2 arguments, le 1er le nom du formulaire (Type) à utiliser et l'entité correspondante à ce formulaire.

        $post=$request->request; // ici on récupère les données en de $_POST
        // si on souhaite récupérer les données de $_GET la commande serait
        // $get=$request->query

        //dump($request); // dump() équivalent de var_dump() en PHP et apparaissant dans la barre de debug de symfony
        //dump($post);

        $form->handleRequest($request); // ici on utilise la méthode handlerequest() de notre objet Form afin de traiter la requête soumise

        if ($form->isSubmitted() && $form->isValid()): // si le formulaire a été envoyé via notre button type submit et que les controles de contraintes éffectués dans notre entité Article et notre formulaire ArticleType, on rentre dans la condition
            $article->setDateCrea(new \DateTime('now'));

            $imageFile=$form->get('photo')->getData(); // equivalent à $_FILES (car notre champs photo dans articleType est de type FILE)
            //dd($imageFile); // dd() equivalent de die() en PHP

            if ($imageFile):

                $nomImage=date("YmdHis")."-".uniqid()."-".$imageFile->getClientOriginalName();

                $imageFile->move(
                    $this->getParameter('images_directory'),
                    $nomImage
                );

                $article->setPhoto($nomImage);

                $manager->persist($article);
                $manager->flush();

                $this->addFlash("success", "L'article a bien été ajouté");

                return $this->redirectToRoute("liste_articles");



            endif;

        endif;



        return $this->render('admin/ajout_article.html.twig',[
            'formu'=>$form->createView()
        ]);

    }


    /**
     * @Route ("/liste_articles", name="liste_articles")
     */
    public function liste_articles(ArticleRepository $articleRepository)
    {

        $articles=$articleRepository->findAll(); //on appelle ici le repository d'article qui nous permet d'effectuer les requêtes de SELECT. Ici SELECT * correspondant à findAll()


        return $this->render('admin/liste_articles.html.twig', [
            'articles'=>$articles
        ]);
    }

    /**
     * @Route ("/modif_article/{id}", name="modif_article")
     */
    public function modif_article(Article $article, Request $request, EntityManagerInterface $manager)
    {
        // ici nous sommes en modification, l'id a transité via l'url et notre objet $article est par conséquent chargé avec toutes ses données en bdd

        $form=$this->createForm(ArticleType::class, $article, array('modifier'=>true));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            $imageFile= $form->get('photoModif')->getData();

        if ($imageFile):

            $nomImage=date('YmdHis')."-".uniqid()."-".$imageFile->getClientOriginalName();

            $imageFile->move($this->getParameter('images_directory'), $nomImage);

            unlink($this->getParameter('images_directory')."/".$article->getPhoto());

            $article->setPhoto($nomImage);

            endif;
                    $manager->persist($article);
                    $manager->flush();

                    $this->addFlash("success", "l'article a bien été modifié");

                    return $this->redirectToRoute('liste_articles');

            endif;



        return $this->render('admin/modif_article.html.twig', [
            'formu'=>$form->createView(),
            'article'=>$article


        ]);

    }

    /**
     * @Route ("/supprime_article/{id}", name="supprime_article")
     */
    public function supprime_article(Article $article, EntityManagerInterface $manager)
    {
        $manager->remove($article);
        $manager->flush();
        $this->addFlash("success", "l'article a bien été supprimé");

        return $this->redirectToRoute('liste_articles');

    }


    /**
     *@Route ("/modif_categorie/{id}", name="modif_categorie")
     *@Route("/ajout_categorie", name="ajout_categorie")
     */
    public function ajout_categorie(Request $request, EntityManagerInterface $manager, Categorie $categorie=null )
    {

        if (!$categorie): // si il n'y a pas d'objet catégorie, on instancie un nouvel objet catégorie, alors on est en ajout
        $categorie=new Categorie();
        endif;

        $form=$this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()):

            $idCategorie=$categorie->getId();
            $manager->persist($categorie);
            $manager->flush();

            if ($idCategorie ==null):
                $this->addFlash('success', 'la catégorie a bien été ajoutée');
                else:
                    $this->addFlash('success', 'la catégorie a bien été modifiée');
                    endif;

            return $this->redirectToRoute('liste_categories');

            endif;

        return $this->render("admin/ajout_categorie.html.twig",[
           'formu'=>$form->createView()
        ]);
    }

    /**
     *@Route("/liste_categories", name="liste_categories")
     */
    public function liste_categories(CategorieRepository $repository)
    {

        $categories=$repository->findAll();
        return $this->render("admin/liste_categories.html.twig",[
            'categories'=>$categories
        ]);
    }

    /**
     * @Route ("/supprime_categorie/{id}", name="supprime_categorie")
     */
    public function supprime_categorie(Categorie $categorie, EntityManagerInterface $manager)
    {
        $manager->remove($categorie);
        $manager->flush();
        $this->addFlash("success", "la catégorie a bien été supprimée");

        return $this->redirectToRoute('liste_categories');

    }

    /**
     * @Route("/addcart/{id}/{param}", name="addcart")
     */
    public function addToCart($id,$param, PanierService $panierService)
    {
        $panierService->add($id);
        $panier=$panierService->getFullPanier();

        if ($param=='home'):
        return $this->redirectToRoute("home",['panier'=>$panier]);
        else:
            return $this->redirectToRoute("cart");
            endif;


    }

    /**
     * @Route("/removecart/{id}", name="removecart")
     */
    public function removeFromCart($id, PanierService $panierService)
    {
        $panierService->remove($id);

        return $this->redirectToRoute("cart");

    }

    /**
     * @Route("/deletecart/{id}", name="deletecart")
     */
    public function deleteFromCart($id, PanierService $panierService)
    {
        $panierService->delete($id);

        return $this->redirectToRoute("cart");

    }

    /**
     * @Route("/cart", name="cart")
     */
    public function cart(PanierService $panierService)
    {

        $panier=$panierService->getFullPanier();
        $total=$panierService->getTotal();

       return $this->render("front/panier.html.twig",[
           'panier'=>$panier,
           'total'=>$total
       ]);
    }

    /**
     * @Route("/verif_promo", name="verif_promo")
     */
    public function verif_promo(Request $request,SessionInterface $session, PromoRepository $promoRepository, PanierService $panierService)
    {

        if (!empty($request->request)):
        $promo=$promoRepository->findBy(['nom'=>$request->request->get('promo')]);
        //dd($nom);
            if ($promo):
            $datefin=$promo[0]->getDateFin();
            $datef=$datefin->getTimestamp();
            $now=strtotime("now");
            $user=$this->getUser();
            $statut=$user->getPromo();
            $total=$panierService->getTotal();
            $panier=$panierService->getFullPanier();
        if ($promo && $statut==0 && ($now<=$datef) && ($total >= $promo[0]->getMontantmin())):
            $totalRemise=$panierService->getTotalRemise($promo[0]->getRemise());
            $this->addFlash('success', 'Félicitation vous bénéficiez de notre remise fidélité');
          // cesaire
            $session->set('remise',$promo[0]->getRemise());

       return $this->render('front/panier.html.twig',[
           'totalremise'=>$totalRemise,
           'panier'=>$panier,
           'total'=>$total
       ]);

       endif;

        else:
            $this->addFlash('alert', 'Votre code promo n\'est pas valide');
            return $this->redirectToRoute('cart');
        endif;
  endif;
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/commande/{param}", name="commande")
     */
    public function commande(PanierService $panierService,SessionInterface $session,EntityManagerInterface $manager, $param=null)
    {
        $panier=$panierService->getFullPanier();

        $commande= new Commande();

        $commande->setUser($this->getUser());

        if ($param!==null):
        $commande->setMontantTotal($panierService->getTotalRemise($session->get('remise')));
        $user=$this->getUser();
        $user->setPromo(1);
        $manager->persist($user);
        else:
            $commande->setMontantTotal($panierService->getTotal());
        endif;
        $commande->setDate(new \DateTime());

        foreach ($panier as $item):
                $article=$item['article'];
                $achat=new Achat();
                $achat->setArticle($article);
                $achat->setQuantite($item['quantite']);
                $achat->setPrixTotal($article->getPrix()*$item['quantite']);
                $achat->setCommande($commande);
                $manager->persist($achat);
                $panierService->delete($article->getId());

            endforeach;
            $manager->persist($commande);
            $manager->flush();
            $this->addFlash('success','Votre commande a bien été prise en compte, merci de votre achat');


        return $this->redirectToRoute('home', ['panier'=>$panier]);

    }

    /**
     * @Route("/commandes_admin",name="commandes_admin")
     */
    public function commandes_admin(CommandeRepository $repository)
    {
       $commandes=$repository->findAll();

       return $this->render("admin/commandes_admin.html.twig", [

           'commandes'=>$commandes
       ]);
    }

    /**
     * @Route("/send", name="send_mail")
     */
    public function send_mail(Request $request)
    {

        $transporter=(new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
            ->setUsername('767Paris4@gmail.com')
            ->setPassword('Session767Paris4');


        $mailer=new \Swift_Mailer($transporter);

        $mess=$request->request->get('message');
        $nom=$request->request->get('surname');
        $prenom=$request->request->get('name');
        $motif=$request->request->get('need');
        $from=$request->request->get('email');

        $message=(new \Swift_Message("$motif"))
            ->setFrom($from)
            ->setTo(['dorancocovid2021@gmail.com']);

            $cid=$message->embed(\Swift_Image::fromPath('Photos/Cover-La-vie-de-créatrice-de-bijoux.gif'));
            $message->setBody(
                $this->renderView('front/mail_template.html.twig',[
                    'message'=>$mess,
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'motif'=>$motif,
                    'email'=>$from,
                    'cid'=>$cid
                ]),
                'text/html'
            );
            $mailer->send($message);

            $this->addFlash('success', 'Email envoyé');
            return $this->redirectToRoute('home');

    }

    /**
     * @Route("/liste_promos",name="liste_promos")
     */
    public function liste_promos(PromoRepository $repository)
    {

        $promos=$repository->findAll();
        return $this->render('admin/liste_promos.html.twig',[
            'promos'=>$promos
        ]);
    }

    /**
     *
     * @Route ("/ajout_promo",name="ajout_promo")
     */
    public function ajout_promo(Request $request,EntityManagerInterface $manager,UserRepository $userRepository)
    {
//        if (!$promo):
        $promo=new Promo();
//        endif;
        $datedebut=strtotime("now"); // timestamp de la date actuelle
        $date= strtotime("now + 10 day");
        $datef=date('d-m-Y',$date);

        $datefin=date('Y-m-d',$date);
        //dd($datefin);
        $dated=date('d-m-Y', $datedebut);


        $form=$this->createForm(PromoType::class, $promo);
        $form->handleRequest($request);
        $users=$userRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()):
            $promo->setStatut(0);
            $promo->setDateDebut(new \DateTime());
            $promo->setDateFin(new \DateTime($datefin));

            $promotion=$request->request->get('promo')['nom'];
            $remise=$request->request->get('promo')['remise'];
            $montant=$request->request->get('promo')['montantmin'];

            $transporter=(new \Swift_SmtpTransport('smtp.gmail.com', 465, 'ssl'))
                ->setUsername('767Paris4@gmail.com')
                ->setPassword('Session767Paris4');


            foreach ($users as $user):
            $mailer=new \Swift_Mailer($transporter);

            $nom=$user->getNom();
            $prenom=$user->getPrenom();
            $mess="Bonne nouvelle !! Du $dated au $datef pour tout achat d'un montant minimum de $montant €, vous bénéficiez d'une remise de $remise € avec le code-promo suivant: $promotion . Venez vite en profiter!";

            $motif="Nouvelle promotion";
            $from='dorancocovid2021@gmail.com';

            $message=(new \Swift_Message("$motif"))
                ->setFrom($from)
                ->setTo([$user->getEmail()]);

            $cid=$message->embed(\Swift_Image::fromPath('Photos/Cover-La-vie-de-créatrice-de-bijoux.gif'));
            $message->setBody(
                $this->renderView('front/mail_template.html.twig',[
                    'message'=>$mess,
                    'nom'=>$nom,
                    'prenom'=>$prenom,
                    'motif'=>$motif,
                    'email'=>$from,
                    'cid'=>$cid
                ]),
                'text/html'
            );
            $mailer->send($message);

                $user->setPromo(0);
                $manager->persist($user);

            endforeach;



            $manager->persist($promo);
            $manager->flush();


            $this->addFlash('success', 'Votre code promo a bien été ajouté');
            return $this->redirectToRoute('liste_promos');

            endif;


       return $this->render('admin/ajout_promo.html.twig',[
           'formu'=>$form->createView()
       ]);
    }

    /**
     * @Route("/supprime_promo/{id}", name="supprime_promo")
     */
    public function supprime_promo(Promo $promo)
    {
        return $this->redirectToRoute('liste_promos');
    }






}
