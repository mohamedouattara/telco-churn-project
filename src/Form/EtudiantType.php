<?php 
        namespace App\Form;

        use App\Entity\Etudiant;
        use Symfony\Component\Form\AbstractType;
        use Symfony\Component\Form\FormBuilderInterface;
        use Symfony\Component\OptionsResolver\OptionsResolver;
        use Symfony\Component\Form\Extension\Core\Type\DateType;
        use Symfony\Component\Form\Extension\Core\Type\NumberType;
        
        class EtudiantType extends AbstractType
        {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
        $builder->add('Nom')->add('Prenom')->add('Date', DateType::class, ['widget' => 'single_text',]);
        } public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    'data_class' => Etudiant::class,
                ]);
            }
        }
        