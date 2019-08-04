<?php

    namespace App\Controller;
    
   // use App\Entity\Vente;
   // use App\Form\VenteType;
   // use App\Repository\VenteRepository;
    
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    /**
     * @Route("/vente")
     */
    class VenteController extends AbstractController
    {
       
        /**
         * @Route("/prediction", name="vente_prediction", methods={"GET","POST"})
         */
        public function prediction(Request $request): Response
        {
            
            $form = $this->createFormBuilder()
            
                        ->add("article", ChoiceType::class, [
                                'choices'  => [
                                    'tomate' => 'tomate','oignon' => 'oignon',
                                ],
                            ])
                ->add("prixunitaire", NumberType::class, ["html5" => true])
                ->add("dateP", DateType::class, ['widget' => 'single_text'])
            ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                dump($form->getData());exit;
            }
    
            return $this->render('__prediction/vente/prediction.html.twig', [
                'form' => $form->createView(),
            ]);
        }
          
    }
  
    