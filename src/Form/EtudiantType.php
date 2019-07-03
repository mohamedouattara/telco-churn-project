<?php 
        namespace App\Form;

        use App\Entity\Etudiant;
        use Symfony\Component\Form\AbstractType;
        use Symfony\Component\Form\FormBuilderInterface;
        use Symfony\Component\OptionsResolver\OptionsResolver;
        use Symfony\Component\Form\Extension\Core\Type\DateType;
        use Symfony\Component\Form\Extension\Core\Type\NumberType;
        use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
        use App\Form\Enums\EtudiantTypeEnum;
        
        class EtudiantType extends AbstractType
        {
        public function buildForm(FormBuilderInterface $builder, array $options)
        {
        $builder->add('Nom')->add('Prenom')->add('Age', NumberType::class)->add('Datedenaissance', DateType::class, ['widget' => 'single_text',]);
        } public function configureOptions(OptionsResolver $resolver)
            {
                $resolver->setDefaults([
                    'data_class' => Etudiant::class,
                ]);
            }
        }
        