<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', TextType::class, ['required' => true])
            ->add('marque', TextType::class, ['required' => false])
            ->add('couleur', TextType::class)
            ->add('carburant', TextType::class)
            ->add('description', TextareaType::class)
            ->add('datemiseencirculation', DateTimeType::class)
            ->add('nbrplace', IntegerType::class, array('attr' => array('min' => 1)))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
