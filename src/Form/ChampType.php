<?php

namespace App\Form;

use App\Entity\Champ;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChampType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelleChamp')
            ->add('typeChamp', ChoiceType::class, [
                'choices'  => [
                    'Chaine de caractère' => 'string',
                    'Date' => 'datetime',
                    'Numérique' => 'float',
                ],
                'attr' => ['class' => 'browser-default']
            ])
            //->add('table_')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Champ::class,
        ]);
    }
}
