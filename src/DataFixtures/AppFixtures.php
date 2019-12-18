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
        $lpNum->setNom("DU TIC");
        $lpNum->setNomComplet("Diplome Universitaire des Technologies de l'Information et de la Communication");

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
            $entreprise->setActivité($faker->jobTitle);

            //Préparation du nom de l'entreprise
            $nomEntreprise = str_replace(' ','_',$entreprise->getNom()); //Enlève les espace au nom d'entreprise
            $nomEntreprise = str_replace('.','',$nomEntreprise); //Enlève les points 
            $entreprise->setSite(strtolower($faker->regexify('http\:\/\/'.$nomEntreprise.'\.'.$faker->tld)));

            $manager->persist($entreprise);

            //Definition des stages associé à l'entreprise
            $nbStages = $faker->numberBetween($min=1, $max=3);
            for ($y=0; $y<$nbStages; $y++) { 
                //Création d'un stage
                $stage = new Stage();
                $stage->setTitre($entreprise->getActivité());
                $stage->setmail(strtolower($faker->regexify(str_replace('É','é',$faker->firstName).'\.'.$faker->lastName.'@'.$nomEntreprise.'\.com')));
                $stage->setDescription($faker->realText($maxNbChars = 500, $indexSize = 2));
                $stage->setEntreprise($entreprise);

                //Ajout des formations au stage
                $nbFormations = $faker->numberBetween($min=1,$max=3);

                switch ($nbFormations) {
                    case '1':
                        $numTypeFormation = $faker->numberBetween($min=0, $max=2);
                        $stage->addFormation($tabTypeFormation[$numTypeFormation]);
                        //Ajout du stage à la formation
                        $tabTypeFormation[$numTypeFormation]->addStage($stage);
                        $manager->persist($tabTypeFormation[$numTypeFormation]);
                        break;
                    
                    case '2':
                        $numTypeFormation1 = $faker->numberBetween($min=0, $max=2);
                        $numTypeFormation2 = $faker->numberBetween($min=0, $max=2);
                        $stage->addFormation($tabTypeFormation[$numTypeFormation1]);
                        //Ajout du stage à la formation1
                        $tabTypeFormation[$numTypeFormation1]->addStage($stage);
                        $manager->persist($tabTypeFormation[$numTypeFormation1]);

                        if ($numTypeFormation1!=$numTypeFormation2) {
                            //Ajout du stage à la formation2 si les 2 formations tirées sont différentes
                            $stage->addFormation($tabTypeFormation[$numTypeFormation2]);
                            $manager->persist($tabTypeFormation[$numTypeFormation2]);
                        }
                        break;

                    default:    // 3 formations
                        // Formation 1
                        $stage->addFormation($tabTypeFormation[0]);
                        $tabTypeFormation[0]->addStage($stage);
                        $manager->persist($tabTypeFormation[0]);

                        // Formation 2
                        $stage->addFormation($tabTypeFormation[1]);
                        $tabTypeFormation[1]->addStage($stage);
                        $manager->persist($tabTypeFormation[1]);

                        // Formation 3
                        $stage->addFormation($tabTypeFormation[2]);
                        $tabTypeFormation[2]->addStage($stage);
                        $manager->persist($tabTypeFormation[2]);
                        break;
                }

                $manager->persist($stage);
                
                //Ajout du stage à l'entreprise
                $entreprise->addEntreprise($stage);//La méthode n'a pas le bon nom (Mauvaise génération)
                $manager->persist($entreprise);
            }
        }

        $manager->flush();
    }
}
