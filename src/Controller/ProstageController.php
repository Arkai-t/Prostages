<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stage;
use App\Entity\Entreprise;
use App\Entity\Formation;

class ProstageController extends AbstractController
{
    public function index()
    {
        $repoStage = $this->getDoctrine()->getRepository(Stage::class);

        $stages = $repoStage->findAll();

        return $this->render('prostage/index.html.twig',['stages'=>$stages]);
    }

    public function entreprises()
    {
        $repoEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprises = $repoEntreprise->findAll();

        return $this->render('prostage/affichageEntreprises.html.twig',['entreprises'=>$entreprises]);
    }

    public function entreprise($id)
    {
        $repoEntreprise = $this->getDoctrine()->getRepository(Entreprise::class);

        $entreprise = $repoEntreprise->find($id);

        return $this->render('prostage/affichageEntreprise.html.twig',['entreprise' => $entreprise]);
    }

    public function formations()
    {
        $repoFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formations = $repoFormation->findAll();

        return $this->render('prostage/affichageFormations.html.twig',['formations' => $formations]);
    }

    public function formation($id)
    {
        $repoFormation = $this->getDoctrine()->getRepository(Formation::class);

        $formation = $repoFormation->find($id);

        return $this->render('prostage/affichageFormation.html.twig',['formation' => $formation]);
    }

    public function stage($id)
    {
        $repoStage = $this->getDoctrine()->getRepository(Stage::class);

        $stage = $repoStage->find($id);

        return $this->render('prostage/affichageStage.html.twig',['stage' => $stage]);
    }
}
