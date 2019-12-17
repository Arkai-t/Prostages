<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // Creation d'un générateur de données Faker
        $faker = \Faker\Factory::create('fr_FR'); // create a French faker

        //Definition des Formations
        $dutInfo = new Formation();
        $dutInfo->setNom("DUT Info");
        $dutInfo->setNomComplet("DUT Informatique");

        $lpProg = new Formation();
        $lpProg->setNom("Lp Prog");
        $lpProg->setNomComplet("License professionnel Programmation avancée");

        $lpNum = new Formation();
        $lpNum->setNom("Lp Num");
        $lpNum->setNomComplet("License professionnel Métiers du Numérique");

        $tabTypeFormation = array($dutInfo, $lpNum, $lpProg); //Tableau des formations

        foreach ($tabTypeFormation as $typeModule) {
            $manager->persist($typeModule);
        }

        //Definition des Entreprises
        $nbEntreprises =10;
        for ($i=0; $i<$nbEntreprises ; $i++) { 
            //Création d'une entreprise
            $entreprise = new Entreprise();
            $entreprise->setNom($faker->company);
            $entreprise->setAdresse($faker->address);
            $entreprise->setActivité($faker->sentence($nbWords =100, $variableNbWords = true));

            //Préparation du nom de l'entreprise
            $nomEntreprise = str_replace(' ','_',$entreprise->getNom()); //Enlève les espace au nom d'entreprise
            $nomEntreprise = str_replace('.','',$nomEntreprise); //Enlève les points 
            $entreprise->setSite(strtolower($faker->regexify('http\:\/\/'.$nomEntreprise.'\.'.$faker->tld)));

            $manager->persist($entreprise);

            //Definition des stages
            $nbStages = $faker->numberBetween($min=1, $max=3);
            for ($y=0; $y<$nbStages; $y++) { 
                //Création d'un stage
                $stage = new Stage();
                $stage->setTitre($faker->sentence($nbWords =15, $variableNbWords = true));
                $stage->setmail(strtolower($faker->regexify($faker->firstName.'\.'.$faker->lastName.'@'.$nomEntreprise.'\.com')));
                $stage->setDescription($faker->realText($maxNbChars = 200, $indesSize = 2));
                $stage->setEntreprise($entreprise);

                //Ajout d'une formation au stage
                $numTypeFormation = $faker->numberBetween($min=0, $max=2);
                $stage->addFormation($tabTypeFormation[$numTypeFormation]);

                $manager->persist($stage);
                
                //Ajout du stage à la formation
                $tabTypeFormation[$numTypeFormation]->addStage($stage);
                $manager->persist($tabTypeFormation[$numTypeFormation]);

                //Ajout du stage à l'entreprise
                $entreprise->addEntreprise($stage);//La méthode n'a pas le bon nom (Mauvaise génération)
                $manager->persist($entreprise);
            }
        }

        $manager->flush();
    }
}
