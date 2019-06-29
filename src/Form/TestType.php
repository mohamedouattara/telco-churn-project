<?php 
        namespace App\Form;

        use App\Entity\Test;
        use Symfony\Component\Form\AbstractType;
        use Symfony\Component\Form\FormBuilderInterface;
        use Symfony\Component\OptionsResolver\OptionsResolver;
        use Symfony\Component\Form\Extension\Core\Type\DateType;
        use Symfony\Component\Form\Extension\Core\Type\NumberType;
        
        class TestType extends AbstractType
        {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
        $builder->add('Test1')->add('Test2', DateType::class, ['widget' => 'single_text',]);
        } public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    'data_class' => Test::class,
                ]);
            }
        }
        