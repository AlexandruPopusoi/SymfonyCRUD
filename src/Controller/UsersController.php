<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

class UsersController extends AbstractController{
    
    #[Route('/users', name: "read_user")]
    public function read_user(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
            $customers = $repository->findAll();

            return $this->render(
                'User.html.twig',
                array('User' => $customers)
            );
    }
}