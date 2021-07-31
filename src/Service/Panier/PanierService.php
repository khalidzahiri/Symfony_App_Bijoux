<?php
namespace App\Service\Panier;


use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class PanierService{

    public $session;
    public $articleRepository;


    public function __construct(SessionInterface $session, ArticleRepository $articleRepository )
    {
        $this->session=$session;
        $this->articleRepository=$articleRepository;
    }


    public function add(int $id)
    {
        /**
         * déclaration en session d'un panier qui charge les articles par id et par quantité
         *
         */

        $panier=$this->session->get('panier', []);

       if (!empty($panier[$id])):
            $panier[$id]++;
       else:
            $panier[$id]=1;
       endif;

       $this->session->set('panier', $panier);

    }

    public function remove(int $id)
    {
        /**
         * On supprime la ligne d'article si un seul en quantité, sinon on décrémente la quantié d'articles
         *
         */

        $panier=$this->session->get('panier', []);

        if (!empty($panier[$id])):
            $panier[$id]--;
        else:
            unset($panier[$id]);
        endif;

        $this->session->set('panier', $panier);
    }

    public function delete(int $id)
    {
        /**
         *On vide totalement la ligne d'articles
(peut importe la quantité)         *
         */

        $panier=$this->session->get('panier', []);

        if (!empty($panier[$id])):
             unset($panier[$id]);
        endif;

        $this->session->set('panier', $panier);
    }

    public function getFullPanier() :array
    {
        /**
         * On fait une boucle permettant de synthétiser les ajouts effectués par article avec la quantité correspondante
         *
         */

        $panier=$this->session->get('panier', []);

        $panierDetail=[];

        foreach ($panier as $id=>$quantite):
            if ($quantite<1):$quantite=0;  endif;
            $panierDetail[]=[
                'article'=>$this->articleRepository->find($id),
                'quantite'=>$quantite
            ];
        endforeach;

        return $panierDetail;

    }

    public function getTotal(): int
    {
        $total=0;
        foreach ($this->getFullPanier() as $item):

            $total += $item['article']->getPrix() * $item['quantite'];

            endforeach;

            return $total;
    }

    public function getTotalRemise($remise): int
    {
        $total=0;
        foreach ($this->getFullPanier() as $item):

            $total += $item['article']->getPrix() * $item['quantite'];

        endforeach;

        return $total-$remise;
    }











}
