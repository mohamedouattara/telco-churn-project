<?php

namespace App\Form;

use App\Form\Enums\MessageTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class MessageType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'choices' => MessageTypeEnum::getAvailableTypes(),
                //'choices_as_values' => true,
                'choice_label' => function($choice) {
                    return MessageTypeEnum::getTypeName($choice);
                },
            ))
        ;
    }
}
