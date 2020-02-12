<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class ProstageController extends AbstractController
{
    public function index(StageRepository $repoStage)
    {
        $stages = $repoStage->findAll();

        return $this->render('prostage/index.html.twig', ['stages'=>$stages]);
    }

    public function entreprises(EntrepriseRepository $repoEntreprise)
    {
        $entreprises = $repoEntreprise->findAll();

        return $this->render('prostage/affichageEntreprises.html.twig', ['entreprises'=>$entreprises]);
    }

    public function entreprise(StageRepository $repoStage, Entreprise $entreprise)
    {
        $stages = $repoStage->findByEntreprise($entreprise);
        
       return $this->render('prostage/affichageEntreprise.html.twig', ['entreprise' => $entreprise, 'stages' => $stages]);
    }

    public function formations(FormationRepository $repoFormation)
    {
        $formations = $repoFormation->findAll();

        return $this->render('prostage/affichageFormations.html.twig', ['formations' => $formations]);
    }

    public function formation(StageRepository $repoStage, Formation $formation)
    {
        $stages = $repoStage->findByFormation($formation);

        return $this->render('prostage/affichageFormation.html.twig', ['formation' => $formation, 'stages' => $stages]);
    }

    public function stage(Stage $stage)
    {
        return $this->render('prostage/affichageStage.html.twig', ['stage' => $stage]);
    }

    public function ajoutEntreprise(Request $requetteHttp, ObjectManager $manager)
    {
        $entreprise = new Entreprise();

        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                      -> add('nom', TextType::class)
                                      -> add('adresse', TextType::class)
                                      -> add('activite', TextType::class)
                                      -> add('site', UrlType::class)
                                      -> getForm();

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted() && $formulaireEntreprise->isValid())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('prostageAccueil');
        }

        return $this->render('prostage/ajoutEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }

    public function modificationEntreprise(Request $requetteHttp, ObjectManager $manager, Entreprise $entreprise)
    {
        $formulaireEntreprise = $this -> createFormBuilder($entreprise)
                                      -> add('nom', TextType::class)
                                      -> add('adresse', TextType::class)
                                      -> add('activite', TextType::class)
                                      -> add('site', UrlType::class)
                                      -> getForm();

        $formulaireEntreprise->handleRequest($requetteHttp);

        if($formulaireEntreprise->isSubmitted())
        {
            $manager->persist($entreprise);
            $manager->flush();

            return $this->redirectToRoute('prostageAccueil');
        }

        return $this->render('prostage/modificationEntreprise.html.twig', ['vueFormulaireEntreprise' => $formulaireEntreprise->createView()]);
    }
}
