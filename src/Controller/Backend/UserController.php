<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $UserRepository): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'users' => $UserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $UserRepository, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entity): Response
    {
        $User = new User();
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);
        $User->setRoles(["ROLE_ADMIN"]);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($User, true);
            $User->setPassword(
                $userPasswordHasher->hashPassword(
                    $User,
                    $form->get('password')->getData()

                )
            );

            $entity->persist($User);
            $entity->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/User/new.html.twig', [
            'User' => $User,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $User, UserRepository $UserRepository): Response
    {
        $form = $this->createForm(UserType::class, $User);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($User, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/User/edit.html.twig', [
            'user' => $User,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $User, UserRepository $UserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $User->getId(), $request->request->get('_token'))) {
            $UserRepository->remove($User, true);
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}