<?php

namespace App\Services;

use Symfony\Component\Filesystem\Filesystem;

class ControllerMaker{

    private $entityName;
    private $projectPath;
    private $fs;

    public function __construct($entityName, $projectPath, Filesystem $filesystem)
    {
        $this->entityName = $entityName;
        $this->projectPath = $projectPath;
        $this->fs = $filesystem;
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
    
                return $this->redirectToRoute(\''.$lowercaseEntityName.'_index\');
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
    
                return $this->redirectToRoute(\''.$lowercaseEntityName.'_index\', [
                    \'id\' => $'.$lowercaseEntityName.'->getId(),
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
    
            return $this->redirectToRoute(\''.$lowercaseEntityName.'_index\');
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
}
