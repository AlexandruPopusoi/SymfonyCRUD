<?php

namespace App\Controller;

use App\Entity\CreateUsersForm;
use App\Entity\User;
use App\Form\UpdateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class UpdateController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/update/{id}', name: "update")]

    public function new(Request $request, int $id): Response
    {
        $entityManager = $this->entityManager;
        
        $user = $entityManager->getRepository(User::class)->find($id);

        $delete_id = $user->getId();

        $CreateUsersForm = new CreateUsersForm();       
        
        $CreateUsersForm->setUsername($user->getUsername());
        $CreateUsersForm->setName($user->getName());
        $CreateUsersForm->setSurname($user->getSurname());
        $CreateUsersForm->setEmail($user->getEmail());
        $CreateUsersForm->setPassword($user->getPassword());
        $CreateUsersForm->setBirthDate($user->getBirthDate());

        $form = $this->createForm(UpdateForm::class, $CreateUsersForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $CreateUsersForm = $form->getData();
            // echo($CreateUsersForm->getSurname());
            // $user = new User();
            $user->setUsername($CreateUsersForm->getUsername());
            $user->setPassword($CreateUsersForm->getPassword());
            $user->setName($CreateUsersForm->getName());
            $user->setSurname($CreateUsersForm->getSurname());
            $user->setEmail($CreateUsersForm->getEmail());
            $user->setBirthDate($CreateUsersForm->getBirthDate());
            // $user->setRegDate(new \DateTime());

            $entityManager->persist($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('read_user');
        }


        return $this->renderForm('update.html.twig',[
            'form' => $form,
            'delete_id' => $delete_id
        ]);
    }

}