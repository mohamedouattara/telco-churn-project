<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Services\ControllerMaker;
use App\Services\CRUDMaker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PredictionController extends AbstractController
{
    /**
     * @Route("/prediction", name="prediction")
     */
    public function index()
    {
        return $this->render('prediction/index.html.twig', [
            'controller_name' => 'PredictionController',
            'controller' => 'prediction',
        ]);
    }


    /**
     * @Route("/prediction/upload", name="prediction_upload")
     */
    public function upload(Request $request, Filesystem $filesystem)
    {
        $document = new Document();
        $projectPath = sys_get_temp_dir().'/../home/mohamed/telco-churn-project/';
        $redirection_path = 'prediction_upload';
        $form = $this->createForm(DocumentType::class, $document);
        $name = '';

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
            /*$file = $document->getName();
            $filename = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('upload_directory'),$filename);
            $document->setName($filename);*/
            //$files = $request->files->get('post')['name'];

           // dump($form->getData());exit;

            $files = $document->getName();

            $uploads_directory = $this->getParameter('upload_directory');

            foreach ($files as $file){

                $filename = $file->getClientOriginalName();
                $ext = explode('.', $filename)[1];

                // Il s'agit d'un fichier JSON définisant les paramètres de notre formulaire
                if ( $file->guessExtension() == "txt" and $ext == 'json'){
                    $contents = json_decode(file_get_contents($file->getPathname()), true);

                    $name = array_shift($contents);
                    $redirection_path = $name.'_prediction';


                    $controllerMaker = new ControllerMaker($name,$projectPath,$filesystem,$contents);
                    $crudMaker = new CRUDMaker($name, $projectPath,[],$filesystem);

                     $controllerMaker->buildPredictionController();
                    $crudMaker->buildPredictionTemplates();
                }

                //$filename = md5(uniqid()).'.'.$file->guessExtension();

                $file->move(
                    $uploads_directory,
                    $filename
                );

            }

            return $this->redirectToRoute($redirection_path);
        }
        return $this->render('prediction/upload.html.twig', [
            'form' => $form->createView(),
            'controller' => 'prediction_upload',

            ]);
    }
}
