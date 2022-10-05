<?php

namespace App\Controller\Backend;

use App\Entity\Categorie;
use App\Entity\SubCategorie;
use App\Form\SubCategorieType;
use App\Repository\CategorieRepository;
use App\Repository\SubCategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/categorie/sub_categorie')]
class SubCategorieController extends AbstractController
{
    #[Route('/', name: 'app_sub_categorie_index', methods: ['GET'])]
    public function index(SubCategorieRepository $subCategorieRepository): Response
    {
        return $this->render('Backend/SubCategorie/index.html.twig', [
            'subCategories' => $subCategorieRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sub_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SubCategorieRepository $subCategorieRepository): Response
    {
        $subCategorie = new SubCategorie();
        $form = $this->createForm(SubCategorieType::class, $subCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategorieRepository->save($subCategorie, true);
            return $this->redirectToRoute('app_sub_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/SubCategorie/new.html.twig', [
            'subCategorie' => $subCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sub_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SubCategorie $subCategorie, SubCategorieRepository $subCategorieRepository): Response
    {
        $form = $this->createForm(SubCategorieType::class, $subCategorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $subCategorieRepository->save($subCategorie, true);

            return $this->redirectToRoute('app_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('Backend/SubCategorie/edit.html.twig', [
            'subCategorie' => $subCategorie,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sub_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, SubCategorie $subCategorie, SubCategorieRepository $subCategorieRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $subCategorie->getId(), $request->request->get('_token'))) {
            $subCategorieRepository->remove($subCategorie, true);
        }

        return $this->redirectToRoute('app_sub_categorie_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/switch/{id}', name: 'app_sub_categorie_visibility', methods: "GET")]
    public function switchVisibilityTag(?SubCategorie $subCategorie, SubCategorieRepository $SubCategorieRepository)
    {
        if (!$subCategorie instanceof SubCategorie) {
            return new Response('Categorie non trouvé', 404);
        } else {
            $subCategorie->setEnable(!$subCategorie->isEnable());
            //$subCategorie->isEnable() ? $subCategorie->setEnable(false) : $subCategorie->setEnable(true);
            $SubCategorieRepository->save($subCategorie, true);

            return new Response('Visibility changed', 201);
        }
    }
}