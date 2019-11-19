<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProstageController extends AbstractController
{
    public function index()
    {
        return $this->render('prostage/index.html.twig');
    }

    public function entreprises()
    {
        return $this->render('prostage/affichageEntreprises.html.twig');
    }

    public function formations()
    {
        return $this->render('prostage/affichageFormations.html.twig');
    }

    public function stages($id)
    {
        return $this->render('prostage/affichageStages.html.twig',
        ['idStages' => $id]);
    }
}
