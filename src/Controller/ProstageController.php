<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProstageController extends AbstractController
{
    public function index()
    {
        return $this->render('prostage/index.html.twig');
    }

    public function entreprises()
    {

    }

    public function formations()
    {
        
    }

    public function stages()
    {
        
    }
}
