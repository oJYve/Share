<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;




class SupprCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('categories',EntityType::class,[
                'class'=>Categorie::class, 
                'choices'=>$options['categories'],
                'choice_label'=>'libelle',
                'expanded'=>true,
                'multiple'=>true,
                'label'=>false,
                'mapped'=>false,

            ])
            ->add('Supprimer', SubmitType ::class,[
                'attr'=> ['class' => 'btn btn-primary'], 
                'row_attr' => ['class' => 'text-center mt-4']

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'categories' => [],
        ]);
    }
}
