<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\SupprContactType;


final class ContactController extends AbstractController
{
    #[Route('/mod-liste-contacts', name: 'app_liste_contacts')]
    public function listeContacts(ContactRepository $contactRepository, Request $request, EntityManagerInterface $em): Response
    {
        $contacts = $contactRepository->findAll();
        $form=$this->createForm(supprContactType::class,null,[
            'contacts' => $contacts,
        ]);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                $selectedContacts=$form->get('contacts')->getData();
                foreach($selectedContacts as $contact){
                    $em->remove($contact);
                }
                $em->flush();
                $this->addFlash('notice', 'Contacts supprimées');
                return $this->redirectToRoute('app_liste_contacts');
            }
        }
        return $this->render('contact/liste-contacts.html.twig', [
            'contacts' => $contacts,
            'form'=>$form->createView(),
        ]);
    }

    #[Route('/mod-suppr-contact/{id}', name: 'app_suppr_contact')]
    public function supprContact(Contact $contact, EntityManagerInterface $em): Response
    {
        if($contact != null)
        {
            $em->remove($contact);
            $em->flush();
            $this->addFlash('notice', 'Contact supprimée');
        }
        return $this->redirectToRoute('app_liste_contacts');
    }

}
