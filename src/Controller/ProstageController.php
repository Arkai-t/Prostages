<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Stage;

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
        return $this->render('prostage/affichageEntreprises.html.twig');
    }

    public function formations()
    {
        return $this->render('prostage/affichageFormations.html.twig');
    }

    public function stage($id)
    {
        $repoStage = $this->getDoctrine()->getRepository(Stage::class);

        $stage = $repoStage->find($id);

        return $this->render('prostage/affichageStages.html.twig',['stage' => $stage]);
    }
}
