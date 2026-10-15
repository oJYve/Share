<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType; 
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['attr'=> ['class' => 'form-control'], 'label_attr' => ['class' => 'form_label mt-4']])
            ->add('sujet', TextType::class, ['attr'=> ['class' => 'form-control'], 'label_attr' => ['class' => 'form_label mt-4']])
            ->add('email', EmailType::class, ['attr'=> ['class' => 'form-control'], 'label_attr' => ['class' => 'form_label mt-4']])
            ->add('message', TextareaType::class, ['attr'=> ['class' => 'form-control', 'rows' => '7'], 'label_attr' => ['class' => 'form_label mt-4']])
            ->add('Send', SubmitType::class, ['attr'=> ['class' => 'btn btn-primary'], 'row_attr' => ['class' => 'text-center mt-4']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
