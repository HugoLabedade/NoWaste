<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mot', SearchType::class, [
                'label'=> false,
                'attr'=>[
                    'class'=> 'form-control',
                    'placeholder'=> 'Rechercher...'
                ]
            ])
            ->add('Rechercher', SubmitType::class, [
                'label'=> false, 
                'attr' =>[
                    'class'=> 'glyphicon glyphicon-search'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
