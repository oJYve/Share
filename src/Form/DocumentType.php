<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class DocumentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, ['attr' => ['class' => 'form-control'], 'label_attr' => ['class' => 'form_label mt-4']])

            // liste déroulante remplie avec la table categorie
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'libelle',          // la colonne affichée dans la liste
                'placeholder' => 'Choisir une catégorie',
                'attr' => ['class' => 'form-select'],
                'label_attr' => ['class' => 'form_label mt-4'],
            ])

            // champ d'import de fichier
            ->add('fichier', FileType::class, [
                'mapped' => false,                    // pas de colonne "fichier" dans l'entité
                'required' => true,
                'constraints' => [
                    new File(maxSize: '5M', maxSizeMessage: 'Le fichier ne doit pas dépasser 5 Mo'),
                ],
                'attr' => ['class' => 'form-control'],
                'label_attr' => ['class' => 'form_label mt-4'],
            ])

            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn btn-primary'], 'row_attr' => ['class' => 'text-center mt-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Document::class,
        ]);
    }
}