<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\FormationRepository;

class ProstageController extends AbstractController
{
    public function index(StageRepository $repoStage)
    {
        $stages = $repoStage->findAll();

        return $this->render('prostage/index.html.twig',['stages'=>$stages]);
    }

    public function entreprises(EntrepriseRepository $repoEntreprise)
    {
        $entreprises = $repoEntreprise->findAll();

        return $this->render('prostage/affichageEntreprises.html.twig', ['entreprises'=>$entreprises]);
    }

    public function entreprise(Entreprise $entreprise)
    {
       return $this->render('prostage/affichageEntreprise.html.twig', ['entreprise' => $entreprise]);
    }

    public function formations(FormationRepository $repoFormation)
    {
        $formations = $repoFormation->findAll();

        return $this->render('prostage/affichageFormations.html.twig', ['formations' => $formations]);
    }

    public function formation(Formation $formation)
    {
        return $this->render('prostage/affichageFormation.html.twig', ['formation' => $formation]);
    }

    public function stage(Stage $stage)
    {
        return $this->render('prostage/affichageStage.html.twig', ['stage' => $stage]);
    }
}
