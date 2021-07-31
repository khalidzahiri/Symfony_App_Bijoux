<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    // /**
    //  * @return Article[] Returns an array of Article objects
    //  */

    public function findByPrice($price) //ici nous déclarons une fonction attendant en argument $price,
        // cette fonction a pour objectif d'effectuer une requete de selection des articles avec condition sur le prix
    {
        return $this->createQueryBuilder('a') // ici nous appelons une méthode du repository
        // de symfony nous permetant de customiser les méthodes de bases de select du repository (find(), findAll(), findBy(), findOneBy()) en y ajoutant, des conditions ( WHERE), des limites (setMaxResult) et d'ordonné notre résultat (OrderBY)
            ->andWhere('a.prix <= :maxprix') // ici nous déclarons notre condition parametré avec le : en utilisant l'alias du queryBuilder déclaré plus haut (en l'occurence a de article) et appelons la propriété visée en concaténant a.propriété (en l'occurence ici le prix) cette condition accepte tout les critères de comparaison (=, <, >, <=,>=, !=)
            ->setParameter('maxprix', $price) //ici nous affectons la valeur de notre parametre maxprix avec l'argument $price envoyé dans la foonction
            ->orderBy('a.prix', 'ASC') // ici nous précisé que la requête doit être rendue avec les prix croissants
            ->getQuery() // getQuery pépare la requête
            ->getResult()// getResult nous renvoi le résultat
        ;
    }




    public function findByCategoryAndPrice($cat, $price)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.prix <= :maxprix')
            ->setParameter('maxprix', $price)
            ->andWhere('a.categorie = :cat')
            ->setParameter('cat', $cat)
            ->getQuery()
            ->getResult()
        ;
    }




    // méthode permettant de récupérer la donnée 'nom' de la table patient en bdd
    public function search(string $filter)
    {
        $builder = $this->createQueryBuilder('a');

        $builder
            ->andWhere('a.nom LIKE :nom')
            ->setParameter('nom', '%'. $filter . '%');
//            ->orWhere('a.description LIKE :desc')
//            ->setParameter('desc', '%' . $filter . '%');


        $query = $builder->getQuery();

        return $query->getResult();

    }

    // méthode liée à l'autocomplétion de la barre de recherche

    public function autocomplete($term)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('a.nom, a.description')
            ->where('a.nom LIKE :term')
            ->setParameter('term', '%' . $term . '%');
//            ->orWhere('a.description LIKE :desc')
//            ->setParameter('desc', '%' . $term . '%');

        $arrayAss = $qb->getQuery()
            ->getResult();

        $array = array();

        // le résultat de la requête est bouclé afin d'effectuer la recherche sur chaque ligne de la table patient
        foreach ($arrayAss as $data) {

            $array[] = $data['nom'];
        }

        return $array;
    }




}
