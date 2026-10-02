<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BaseController extends AbstractController
{
    #[Route('/', name: 'app_accueil')] // prends deux paramètre '/' pour l'url et name pour le nom de la Route
    public function index(): Response // déclaration de la méthode qui prend deux paramètre : le nom (index) et le type (Response)
    {
        return $this->render('base/index.html.twig', []); // $this permet d'appeler la méthode render qui se situe dans AbstractController et qui permet de générer la vue user en construisant a partir des fichiers données et des template
    }

    #[Route('/mention', name: 'app_mention-legal')]
    public function legal(): Response
    {
        return $this->render('base/mention-legal.html.twig', []);
    }

    #[Route('/propos', name: 'app_a-propos')]
    public function propos(): Response
    {
        return $this->render('base/a-propos.html.twig', []);
    }

    #[Route('/contact', name: 'app_contact')]
    public function contact(): Response
    {
        return $this->render('base/contact.html.twig', []);
    }
}   