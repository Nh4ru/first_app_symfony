<?php

namespace App\Controller\Backend;

use App\Entity\user;
use App\Form\userType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $UserRepository): Response
    {
        return $this->render('Backend/user/index.html.twig', [
            'users' => $UserRepository->findAll(),
        ]);
    }

    #[Route('/add', name: 'app_user_add', methods: ['GET', 'POST'])]
    public function new(Request $request, UserRepository $UserRepository): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $UserRepository->add($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
}