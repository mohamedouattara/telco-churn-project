<?php

namespace App\Form;

use App\Entity\Dataset;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DatasetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gender')
            ->add('seniorcitizen')
            ->add('partner')
            ->add('dependents')
            ->add('phoneservice')
            ->add('multiplelines')
            ->add('internetservice')
            ->add('onlinesecurity')
            ->add('onlinebackup')
            ->add('deviceprotection')
            ->add('techsupport')
            ->add('streamingtv')
            ->add('streamingmovies')
            ->add('contract')
            ->add('paperlessbilling')
            ->add('paymentmethod')
            ->add('tenure')
            ->add('monthlycharges')
            ->add('totalcharges')
            ->add('churn')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Dataset::class,
        ]);
    }
}
