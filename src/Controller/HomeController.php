<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    #[Route('/', name: 'home1')]
    public function main(): Response
    {
        return $this->renderForm('home.html.twig');
    }
}