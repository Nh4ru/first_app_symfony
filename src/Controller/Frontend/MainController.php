<?php

namespace App\Controller\Frontend;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe Main Controller pour page d'acceuil
 */
class MainController extends AbstractController
{
    /**
     * Récupération des articles
     *
     * @param ArticleRepository $repoArticle
     */
    public function __construct(
        private ArticleRepository $repoArticle
    ) {
    }

    /**
     * Affiche la page d'acceuil
     *
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {
        // Récupère tous les articles
        $articles = $this->repoArticle->findAll();


        return $this->render('Frontend/Home/index.html.twig', [
            'articles' => $articles
        ]);
    }
}