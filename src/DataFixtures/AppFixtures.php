<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1;$i<11;$i++):
        $article= new Article(); // ici on instancie, un nouvel objet hérité de la classe App\entity\Article à chaque tour de boucle, pour autant d'articles instanciés , il y aura un insert supplémentaire en BDD
            $article->setNom("Article N°".$i)
                    ->setPrix(rand(100,400))
                    ->setDateCrea(new \DateTime())
                    ->setRef("ref".$i)
                    ->setPhoto("https://picsum.photos/600/".$i);
            // ici on "habille nos objets Nu instanciés précédemment" avec les setter de nos différentes propriétés héritées de notre objet Article entity
            $manager->persist($article); // persist est une méthode issue de la classe ObjectManager qui permet de garder en mémoire les ojets articles créés précédemments et de préparer et binder les requête (les valeurs à inserer) avant insertion

        endfor;
        $manager->flush();
        // flush est une méthode de ObjectManager qui permet d'éxécuter les requêtes préparées lors du persist() et permet ainsi les inserts en BDD

        // une fois réalisé, il faut charger les Fixtures en BDD grâce à DOCTRINE avec la commande suivante: php bin/console doctrine:fixtures:load

    }
}
