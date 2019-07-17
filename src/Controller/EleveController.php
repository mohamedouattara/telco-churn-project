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
    use Unirest;

    
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
               // $client = new \GuzzleHttp\Client(['base_uri' => 'http://192.168.1.23:5000']);
                //$response = $client->request('GET', 'prediction/mesparamtest');

                // search Songs of Frank Sinatra
                $headers = array('Accept' => 'application/json');
                $query = array(
                    'var' => json_encode($form->getData())
                );

                $response = Unirest\Request::post('http://192.168.1.115:5000/prediction/', $headers, $query);

                if ($response->code == 200){
                    //$data = json_decode($response->body->response, true);
                    dump($response);exit;
                }else{
                    dump($response);exit;
                }
            }
    
            return $this->render('__prediction/eleve/prediction.html.twig', [
                'form' => $form->createView(),
            ]);
        }
          
    }
  
    