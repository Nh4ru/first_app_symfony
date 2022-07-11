<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe Main Controller pour page d'acceuil
 */
class MainController extends AbstractController
{
    /**
     * Affiche la page d'acceuil
     *
     * @Route("/", name="home")
     * @return Response
     */
    public function index()
    {

        $data = [
            'nom' => 'Tristan',
            'age' => 33,
            'ville' => 'Valence'
        ];

        return $this->render('Home/index.html.twig', ['data' => $data]);
    }
}