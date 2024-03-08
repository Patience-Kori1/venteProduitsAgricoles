<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProduitFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
         // Create categories
         $categories = [];
         for ($i = 0; $i < 5; $i++) {
             $categorie = new Categorie();
             $categorie->setNomCategorie($faker->word())
                       ->setImage($faker->imageUrl())
                       ->setDescriptionCategorie($faker->paragraph());
 
             $manager->persist($categorie);
             $categories[] = $categorie;
         }
 
         // Création de plusieurs produits
         for ($i = 0; $i < 20; $i++) {
             $produit = new Produit();
             $produit->setNomProduit($faker->lastName())
                     ->setImage($faker->imageUrl())
                     ->setPrix($faker->randomFloat(2, 10, 100))
                     ->setQuantiteStock($faker->numberBetween(0, 100))
                     ->setDateCreation($faker->dateTimeBetween('-1 year', 'now'))
                     ->setDescriptionCourte($faker->paragraph())
                     ->setCategorie($faker->randomElement($categories));
 
             $manager->persist($produit);
         }
 
         $manager->flush();
    }
}
