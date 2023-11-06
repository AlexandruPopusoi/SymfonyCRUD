<?php

namespace App\Controller;

use App\Entity\DeleteUsersForm;
use App\Entity\User;
use App\Form\DeleteForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class DeleteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/delete/{id}', name: "delete")]

    public function new(Request $request, int $id): Response
    {
        $entityManager = $this->entityManager;
        
        $user = $entityManager->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $DeleteUsersForm = new DeleteUsersForm();       
        
        $delete_id = $user->getId();

        $form = $this->createForm(DeleteForm::class, $DeleteUsersForm);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->remove($user);
            
            $entityManager->flush();

            return $this->redirectToRoute('read_user');
        }

        return $this->renderForm('delete.html.twig',
            ['form' => $form,
                'delete_id' => $delete_id,
                'user' => $user]
        );
    }

}