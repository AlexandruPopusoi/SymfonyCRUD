<?php

namespace App\Controller;

use App\Entity\createUsersForm;
use App\Entity\User;
use App\Form\UpdateForm;
use App\Form\CreateForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class UsersController extends AbstractController{
    
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/users/update/{id}', name: "update")]

    public function update(Request $request, int $id): Response
    {
        $entityManager = $this->entityManager;
        
        $user = $entityManager->getRepository(User::class)->find($id);

        $createUsersForm = new createUsersForm();       
        
        $createUsersForm->setUsername($user->getUsername());
        $createUsersForm->setName($user->getName());
        $createUsersForm->setSurname($user->getSurname());
        $createUsersForm->setEmail($user->getEmail());
        $createUsersForm->setPassword($user->getPassword());
        $createUsersForm->setBirthDate($user->getBirthDate());

        $form = $this->createForm(UpdateForm::class, $createUsersForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $createUsersForm = $form->getData();

            $user->setUsername($createUsersForm->getUsername());
            $user->setPassword($createUsersForm->getPassword());
            $user->setName($createUsersForm->getName());
            $user->setSurname($createUsersForm->getSurname());
            $user->setEmail($createUsersForm->getEmail());
            $user->setBirthDate($createUsersForm->getBirthDate());

            $entityManager->persist($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->renderForm('users/update.html.twig',[
            'form' => $form
        ]);
    }

    #[Route('/users/delete/{id}', name: "delete")]

    public function delete(Request $request, int $id): Response
    {
        $entityManager = $this->entityManager;
        
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No user found for this id: '.$id
            );
        }

        $entityManager->remove($user);
            
        $entityManager->flush();

        return $this->redirectToRoute('list');
    }

    #[Route('/users/create', name: "create")]

    public function create(Request $request): Response
    {
        $entityManager = $this->entityManager;
        
        $createUsersForm = new CreateUsersForm();      

        $form = $this->createForm(CreateForm::class, $createUsersForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $createUsersForm = $form->getData();
            $user = new User();
            $user->setUsername($createUsersForm->getUsername());
            $user->setPassword($createUsersForm->getPassword());
            $user->setName($createUsersForm->getName());
            $user->setSurname($createUsersForm->getSurname());
            $user->setEmail($createUsersForm->getEmail());
            $user->setBirthDate($createUsersForm->getBirthDate());
            $user->setRegDate(new \DateTime());

            $entityManager->persist($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('list');
        }

        return $this->renderForm('users/create.html.twig',[
            'form' => $form
        ]);
    }


    #[Route('/users', name: "list")]
    public function list(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
            $customers = $repository->findAll();

            return $this->render(
                'users/users.html.twig',
                array('User' => $customers)
            );
    }
}