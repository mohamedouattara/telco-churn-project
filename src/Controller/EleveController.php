<?php

    namespace App\Controller;
    
   // use App\Entity\Eleve;
   // use App\Form\EleveType;
   // use App\Repository\EleveRepository;
    
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    /**
     * @Route("/eleve")
     */
    class EleveController extends AbstractController
    {
       
        /**
         * @Route("/prediction", name="eleve_prediction", methods={"GET","POST"})
         */
        public function prediction(Request $request): Response
        {
            
            $form = $this->createFormBuilder()
            
                ->add("Nom")
                ->add("prenom")
                ->add("date_naissance", DateType::class, ['widget' => 'single_text'])
                ->add("age", NumberType::class, ["html5" => true])
                        ->add("sexe", ChoiceType::class, [
                                'choices'  => [
                                    'Masculin' => 'masculin','masculin' => 'masculin','Feminin' => 'feminin',
                                ],
                            ])
                        ->add("quartier", ChoiceType::class, [
                                'choices'  => [
                                    'Cocody' => 'cocody','Koumassi' => 'koumassi','Marcory' => 'marcory','Treichville' => 'treichville','Plateau' => 'plateau',
                                ],
                            ])
            ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                dump($form->getData());exit;
            }
    
            return $this->render('__prediction/eleve/prediction.html.twig', [
                'form' => $form->createView(),
            ]);
        }
          
    }
  
    