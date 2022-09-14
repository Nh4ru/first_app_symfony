<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CompteController extends AbstractController
{

    #[Route('/compte', name: 'app_compte')]
    public function indexCompte(Security $security): Response
    {
        $user = $security->getUser();

        return $this->render('Frontend/User/compte.html.twig', [
            'user' => $user,
        ]);
    }
}