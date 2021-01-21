<?php

namespace App\Form;

use App\Entity\Departement;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('postalCode', IntegerType::class)
            ->add('population', IntegerType::class)
            ->add('image', TextType::class)
            ->add('slug', TextType::class)
            ->add('departement', EntityType::class,
            [
                'class' => Departement::class,
                'choice_label' => 'name',
                'placeholder' => 'Choisir un département',
                'label' => 'Département',
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
