<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SubCategorieController extends AbstractController
{
    #[Route('/sub/categorie', name: 'app_sub_categorie')]
    public function index(): Response
    {
        return $this->render('sub_categorie/index.html.twig', [
            'controller_name' => 'SubCategorieController',
        ]);
    }
}