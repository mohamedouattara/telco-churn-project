<?php 
        namespace App\Form;

        use App\Entity\Classe;
        use Symfony\Component\Form\AbstractType;
        use Symfony\Component\Form\FormBuilderInterface;
        use Symfony\Component\OptionsResolver\OptionsResolver;
        use Symfony\Component\Form\Extension\Core\Type\DateType;
        use Symfony\Component\Form\Extension\Core\Type\NumberType;
        use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
        use App\Form\Enums\ClasseTypeEnum;
        
        class ClasseType extends AbstractType
        {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
        $builder->add('Annee', DateType::class, [
                'widget' => 'single_text', 
                'attr' => ['class' => 'js-datepicker'],
                'html5' => false,
                ])->add('Effectif', NumberType::class)->add('Professeurprincipal');
        } public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    'data_class' => Classe::class,
                ]);
            }
        }
        