<?php

namespace App\Controller\Backend;

use App\Entity\Music;
use App\Repository\MusicRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/user')]
class MusicController extends AbstractController
{
    #[Route('/', name: 'app_music_index', methods: ['GET'])]
    public function index(MusicRepository $MusicRepository): Response
    {
        return $this->render('Backend/User/index.html.twig', [
            'music' => $MusicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_music_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MusicRepository $MusicRepository): Response
    {
        $Music = new Music();
        $form = $this->createForm(UserType::class, $Music);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $MusicRepository->add($Music, true);

            return $this->redirectToRoute('app_music_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/User/new.html.twig', [
            'music' => $Music,
            'form' => $form,
        ]);
    }
}

