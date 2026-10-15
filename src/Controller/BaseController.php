<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ContactType; 
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Document;
use App\Form\DocumentType;

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
    public function contact(Request $request, EntityManagerInterface $em ): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType ::class, $contact);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $contact->setDateEnvoie(new \DateTimeImmutable());
                $em->persist($contact);
                $em->flush();
                $this->addFlash('notice', 'Message envoyé ');
                return $this->redirectToRoute('app_contact');
            }
        }
        return $this->render('base/contact.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/depot', name: 'app_depot')]
    public function depot(Request $request, EntityManagerInterface $em): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                // --- traitement du fichier ---
                $fichier = $form->get('fichier')->getData(); // on récupère le fichier envoyé
                $nomFichier = uniqid() . '.' . $fichier->guessExtension(); // nom unique pour éviter les doublons
                $fichier->move(
                    $this->getParameter('kernel.project_dir') . '/public/uploads', // dossier de destination
                    $nomFichier
                );
                $document->setNomFichier($nomFichier);
                $document->setDateEnvoi(new \DateTime());

                $em->persist($document);
                $em->flush();
                $this->addFlash('notice', 'Fichier envoyé');
                return $this->redirectToRoute('app_depot');
            }
        }
        return $this->render('base/depot.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}   