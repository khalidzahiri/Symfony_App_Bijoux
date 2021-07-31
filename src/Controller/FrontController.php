<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\CommandeRepository;
use App\Service\Panier\PanierService;
use Knp\Component\Pager\PaginatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
        // cette fonction affiche la page d'accueil, d'où sa route configurée sur "/".
    // Toute fonction possédant un return necessite une route en paramètre (géree par Annotion\Route)
    //ainsi qu'un name qui permettra d'appeler cette fonction dans notre twig
    /**
     * @Route ("/", name="home")
     */
    public function home(Request $request,ArticleRepository $articleRepository,CategorieRepository $categorieRepository,PanierService $panierService,PaginatorInterface $paginator) //ici on injecte la dépendance de ArticleRepository afin de pouvoir utiliser les méthode de la classe ArticleRepository
    {

        $prenom="cesaire";
        $nom="desaulle";
        $age=34;
        $panier=$panierService->getFullPanier();
        $categories=$categorieRepository->findAll();


                $articles=$articleRepository->findAll();// on utilise la méthode findAll de ArticleRepository afin de faire une requête de select * de nos articles que nous allons transmettre à notre vue twig

        $articles=$paginator->paginate(
         $articles,
            $request->query->getInt('page', 2),
            6
        );



        return $this->render('front/home.html.twig',[
            'prenom'=>$prenom,
            'nom'=>$nom,
            'age'=>$age,
            'articles'=>$articles,
            'panier'=>$panier,
            'categories'=>$categories

        ]);
    }

    /**
     * @Route ("/homefilter",name="homefilter")
     */
    public function homefilter(ArticleRepository $articleRepository, CategorieRepository $categorieRepository,PanierService $panierService, Request $request, PaginatorInterface $paginator)
    {

        $panier=$panierService->getFullPanier();
        $categories=$categorieRepository->findAll();

        $prixmax=$request->request->get('prixmax');
        $cat=$request->request->get('cat');

        if ($cat=='all' && $prixmax==50):
        $articles=$articleRepository->findAll();
        elseif($cat!=='all' && $prixmax==50):
        $articles=$articleRepository->findBy(['categorie'=>$cat],['prix'=>'ASC']);
        elseif ($cat=='all' && $prixmax!==50):
        $articles=$articleRepository->findByPrice($prixmax);
        elseif ($cat!=='all' && $prixmax!==50):
        $articles=$articleRepository->findByCategoryAndPrice($cat, $prixmax);
        endif;

        $articles=$paginator->paginate(
            $articles,
            $request->query->getInt('page',1),
            2
        );

        return $this->render('front/home.html.twig',[
            'articles'=>$articles,
            'panier'=>$panier,
            'categories'=>$categories
        ]);
    }

    /**
     * @Route ("/commandes_user",name="commandes_user")
     */
    public function commandes_user(CommandeRepository $repository)
    {
        $commandes=$repository->findBy(['user'=>$this->getUser()], ['id'=>'DESC']);

        return $this->render("front/commandes_user.html.twig",[
            'commandes'=>$commandes
        ]);

    }

    /**
     * @Route("/mail_form", name="mail_form")
     */
    public function mail_form()
    {
        return $this->render('front/mail_form.html.twig');
    }


    /**
     * @Route("/mail_template", name="mail_template")
     */
    public function mail_template()
    {
        return $this->render('front/mail_template.html.twig');
    }




























}
