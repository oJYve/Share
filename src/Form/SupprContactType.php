<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SupprContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('contacts',EntityType::class,[
                'class'=>Contact::class, 
                'choices'=>$options['contacts'],
                'choice_label'=>'message',
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
            'contacts' => [],
        ]);
    }
}
