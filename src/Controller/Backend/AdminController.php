<?php

namespace App\Controller\Backend;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Admin Controller
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * Article repository to find article object
     * 
     * @var ArticleRepository
     */
    private $repoArticle;

    /**
     * Article repository to find User object
     * 
     * @var UserRepository
     */
    private $repoUser;

    /**
     * Entity manager interface
     * 
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(ArticleRepository $repoArticle, UserRepository $repoUser, EntityManagerInterface $em)
    {
        $this->repoArticle = $repoArticle;
        $this->repoUser = $repoUser;
        $this->em = $em;
    }

    #[Route('', name: 'admin')]
    public function index(): Response
    {
        // Récupérer tous les users
        $users = $this->repoUser->findAll();

        // Récuperer tous les articles
        $articles = $this->repoArticle->findAll();

        return $this->render('Backend/index.html.twig', [
            'articles'=> $articles,
            'users' => $users,
        ]);
    }

    #[Route('/article/create', name: 'admin.article.create')]
    public function createArticle()
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        return $this->render('Backend/Article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}