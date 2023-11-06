<?php

namespace App\Controller;

use App\Entity\CreateUsersForm;
use App\Entity\User;
use App\Form\Type\CreateForm;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class CreateController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/create', name: "create")]

    public function new(Request $request): Response
    {
        $entityManager = $this->entityManager;
        
        $CreateUsersForm = new CreateUsersForm();      

        $form = $this->createForm(CreateForm::class, $CreateUsersForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $CreateUsersForm = $form->getData();
            $user = new User();
            $user->setUsername($CreateUsersForm->getUsername());
            $user->setPassword($CreateUsersForm->getPassword());
            $user->setName($CreateUsersForm->getName());
            $user->setSurname($CreateUsersForm->getSurname());
            $user->setEmail($CreateUsersForm->getEmail());
            $user->setBirthDate($CreateUsersForm->getBirthDate());
            $user->setRegDate(new \DateTime());

            $entityManager->persist($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('read_user');
        }

        return $this->renderForm('task/create.html.twig',[
            'form' => $form
        ]);
    }

}