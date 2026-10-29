<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CategorieRepository;
use App\Form\CategorieType;
use App\Form\ModifCategorieType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SupprCategorieType;


final class CategorieController extends AbstractController
{
    #[Route('/private-creer-categorie', name: 'app_creer_categorie')]
    public function creerCategorie(Request $request, EntityManagerInterface $em): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', ' Catégorie créer ');
                return $this->redirectToRoute('app_creer_categorie');
            }
        }
        return $this->render('categorie/creer-categorie.html.twig', [
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/private-liste-categories', name: 'app_liste_categories')]
    public function listeCategorie(CategorieRepository $categorieRepository, Request $request, EntityManagerInterface $em): Response
    {
        $categories = $categorieRepository->findAll(); 
        $form = $this->createForm(SupprCategorieType::class,null,[
            'categories'=>$categories
        ]);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $selectedCategories=$form->get('categories')->getData();
                foreach($selectedCategories as $categorie){
                    $em->remove($categorie);
                }
                $em->flush();
                $this->addFlash('notice', 'Catégories supprimées');
                return $this->redirectToRoute('app_liste_categories');
            }
        }
        return $this->render('categorie/liste-categories.html.twig', [
            'categories' => $categories,
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/private-modif-categorie/{id}', name: 'app_modif_categorie')]
    public function modifCategorie(Categorie $categorie, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ModifCategorieType::class, $categorie);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $em->persist($categorie);
                $em->flush();
                $this->addFlash('notice', 'Catégorie modifiée');
                return $this->redirectToRoute('app_liste_categories');
            }
        }
        return $this->render('categorie/modif-categorie.html.twig',[
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/private-suppr-categorie/{id}', name: 'app_suppr_categorie')]
    public function supprCategorie(Categorie $categorie, EntityManagerInterface $em): Response
    {
        if($categorie != null)
        {
            $em->remove($categorie);
            $em->flush();
            $this->addFlash('notice', 'Catégorie supprimée');
        }
        return $this->redirectToRoute('app_liste_categories');
    }

}
