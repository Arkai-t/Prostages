<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProstageController extends AbstractController
{
    public function index()
    {
        return new Response('<html><body><h1>Bienvenue sur la page d\'accueil de Prostages</h1></body></html>');
    }

    public function entreprises()
    {
        return new Response('<html><body><h1>Cette page affichera la liste des entreprises proposant un stage</h1></body></html>');
    }

    public function formations()
    {
        return new Response('<html><body><h1>Cette page affichera la liste des formations de l\'IUT</h1></body></html>');
    }

    public function stages($id)
    {
        return new Response('<html><body><h1>Cette page affichera le descriptif du stage ayant pour identifiant '.$id.'</h1></body></html>');
    }
}
