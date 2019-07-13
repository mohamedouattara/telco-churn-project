<?php

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;

class ControllerMaker{

    private $entityName;
    private $projectPath;
    private $fs;
    private $predictionFields;

    public function __construct($entityName, $projectPath, Filesystem $filesystem, $predictionFields = [])
    {
        $this->entityName = $entityName;
        $this->projectPath = $projectPath;
        $this->fs = $filesystem;
        $this->predictionFields = $predictionFields;
    }

    public function buildController(){
        $capitalizeEntityName = ucfirst($this->entityName);
        $lowercaseEntityName = strtolower($this->entityName);
        $generatedController = '';
        $generationResult = array(
            "ControllerFolderExist" => True,
            "ControllerFileIsGenerated" => False,
        );

        $generatedController = '<?php

    namespace App\Controller;
    
    use App\Entity\\'.$capitalizeEntityName.';
    use App\Form\\'.$capitalizeEntityName.'Type;
    use App\Repository\\'.$capitalizeEntityName.'Repository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    /**
     * @Route("/'.$lowercaseEntityName.'")
     */
    class '.$capitalizeEntityName.'Controller extends AbstractController
    {
        /**
         * @Route("/", name="'.$lowercaseEntityName.'_index", methods={"GET"})
         */
        public function index('.$capitalizeEntityName.'Repository $'.$lowercaseEntityName.'Repository): Response
        {
            return $this->render(\''.$lowercaseEntityName.'/index.html.twig\', [
                \''.$lowercaseEntityName.'s\' => $'.$lowercaseEntityName.'Repository->findAll(),
            ]);
        }
    
        /**
         * @Route("/new", name="'.$lowercaseEntityName.'_new", methods={"GET","POST"})
         */
        public function new(Request $request): Response
        {
            $'.$lowercaseEntityName.' = new '.$capitalizeEntityName.'();
            $form = $this->createForm('.$capitalizeEntityName.'Type::class, $'.$lowercaseEntityName.');
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($'.$lowercaseEntityName.');
                $entityManager->flush();
    
                return $this->redirectToRoute(\'dataset_index\');
            }
    
            return $this->render(\''.$lowercaseEntityName.'/new.html.twig\', [
                \''.$lowercaseEntityName.'\' => $'.$lowercaseEntityName.',
                \'form\' => $form->createView(),
            ]);
        }
    
        /**
         * @Route("/{id}", name="'.$lowercaseEntityName.'_show", methods={"GET"})
         */
        public function show('.$capitalizeEntityName.' $'.$lowercaseEntityName.'): Response
        {
            return $this->render(\''.$lowercaseEntityName.'/show.html.twig\', [
                \''.$lowercaseEntityName.'\' => $'.$lowercaseEntityName.',
            ]);
        }
    
        /**
         * @Route("/{id}/edit", name="'.$lowercaseEntityName.'_edit", methods={"GET","POST"})
         */
        public function edit(Request $request, '.$capitalizeEntityName.' $'.$lowercaseEntityName.'): Response
        {
            $form = $this->createForm('.$capitalizeEntityName.'Type::class, $'.$lowercaseEntityName.');
            $form->handleRequest($request);
    
            if ($form->isSubmitted() && $form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
    
                return $this->redirectToRoute(\'dataset_index\', [
                    //\'id\' => $'.$lowercaseEntityName.'->getId(),
                ]);
            }
    
            return $this->render(\''.$lowercaseEntityName.'/edit.html.twig\', [
                \''.$lowercaseEntityName.'\' => $'.$lowercaseEntityName.',
                \'form\' => $form->createView(),
            ]);
        }
    
        /**
         * @Route("/{id}", name="'.$lowercaseEntityName.'_delete", methods={"DELETE"})
         */
        public function delete(Request $request, '.$capitalizeEntityName.' $'.$lowercaseEntityName.'): Response
        {
            if ($this->isCsrfTokenValid(\'delete\'.$'.$lowercaseEntityName.'->getId(), $request->request->get(\'_token\'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($'.$lowercaseEntityName.');
                $entityManager->flush();
            }
    
            return $this->redirectToRoute(\'dataset_index\');
        }
    }
    
            
    ';

        try{
            if($this->fs->exists($this->projectPath.'src/Controller')){// Verifie si le repertoire existe
                if ($this->fs->exists($this->projectPath.'src/Controller/'.$this->entityName.'Controller.php')){
                    $generationResult['ControllerFileIsGenerated'] = True;
                    //return [False, "Le fichier Controller $this->entityName existe déja"];
                }else{
                    $this->fs->appendToFile($this->projectPath.'src/Controller/'.$this->entityName.'Controller.php', $generatedController);
                    $generationResult['ControllerFileIsGenerated'] = True;
                    //return [True, "Le fichier Entity $this->entityName à été créé avec succès"];
                }
            }else{// Sinon on retourne une erreur
                $generationResult['ControllerFolderExist'] = False;
                $generationResult['ControllerFileIsGenerated'] = False;
                //return [False, "Le répertoire Controller $this->entityName  auquel vous tentez d'accéder n'existe pas"];
            }

        }catch (\Exception $e){
            return "Message : ".$e->getMessage();
        }
    }


    //-----------------------------------------------------------

    /**
     * @return String
     */
    public function buildPredictFormField()
    {
        $result = '';



        //dump($this->predictionFields);
        foreach ($this->predictionFields as $field){


            if($field['type'] == 'string'){
                $result .= '
                ->add("'.$field["nom"].'")';
            }
            elseif ($field['type'] == 'date'){
                $result .= '
                ->add("'.$field["nom"].'", DateType::class, [\'widget\' => \'single_text\'])';
            }
            elseif ($field['type'] == 'numeric'){
                $result .= '
                ->add("'.$field["nom"].'", NumberType::class, ["html5" => true])';
            }
            elseif ($field['type'] == 'categorical'){
                $choices = '';
                foreach ($field['unique_values'] as $choice){

                    $choices .= "'".$choice."' => '".strtolower($choice)."',";
                }
                $result .= '
                        ->add("'.$field["nom"].'", ChoiceType::class, [
                                \'choices\'  => [
                                    '.$choices.'
                                ],
                            ])';
            }




        }
        //dump($result);exit;

        return $result;
    }

    public function buildPredictionController(){
        $name = $this->entityName;
        $capitalizeEntityName = ucfirst($name);
        $lowercaseEntityName = strtolower($name);
        $generatedController = '';
        $generationResult = array(
            "ControllerFolderExist" => True,
            "ControllerFileIsGenerated" => False,
        );

        $generatedController = '<?php

    namespace App\Controller;
    
   // use App\Entity\\'.$capitalizeEntityName.';
   // use App\Form\\'.$capitalizeEntityName.'Type;
   // use App\Repository\\'.$capitalizeEntityName.'Repository;
    
    use Symfony\Component\Form\Extension\Core\Type\NumberType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    /**
     * @Route("/'.$lowercaseEntityName.'")
     */
    class '.$capitalizeEntityName.'Controller extends AbstractController
    {
       
        /**
         * @Route("/prediction", name="'.$lowercaseEntityName.'_prediction", methods={"GET","POST"})
         */
        public function prediction(Request $request): Response
        {
            
            $form = $this->createFormBuilder()
            '.$this->buildPredictFormField().'
            ->getForm();
            
            $form->handleRequest($request);
            
            if ($form->isSubmitted() && $form->isValid()){
                dump($form->getData());exit;
            }
    
            return $this->render(\'__prediction/'.$lowercaseEntityName.'/prediction.html.twig\', [
                \'form\' => $form->createView(),
            ]);
        }
          
    }
  
    ';



        try{
            if($this->fs->exists($this->projectPath.'src/Controller')){// Verifie si le repertoire existe
                if ($this->fs->exists($this->projectPath.'src/Controller/'.$capitalizeEntityName.'Controller.php')){
                    $generationResult['ControllerFileIsGenerated'] = True;
                    //return [False, "Le fichier Controller $this->entityName existe déja"];
                }else{
                    $this->fs->appendToFile($this->projectPath.'src/Controller/'.$capitalizeEntityName.'Controller.php', $generatedController);

                    $generationResult['ControllerFileIsGenerated'] = True;


                    //return [True, "Le fichier Entity $this->entityName à été créé avec succès"];
                }
            }else{// Sinon on retourne une erreur
                $generationResult['ControllerFolderExist'] = False;
                $generationResult['ControllerFileIsGenerated'] = False;
                //return [False, "Le répertoire Controller $this->entityName  auquel vous tentez d'accéder n'existe pas"];
            }

        }catch (\Exception $e){
            return "Message : ".$e->getMessage();
        }
    }
}

