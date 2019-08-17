<?php

namespace App\Controller\test;

use App\Entity\Message;
use App\Form\Enums\MessageTypeEnum;
use App\Form\MessageType;
use App\Services\EntityMaker;
use Doctrine\Common\Collections\ArrayCollection;

use Osms\Osms;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class TestController extends AbstractController
{

    /**
     * @Route("/test/shell", name="shell")
     */

    public function shell()
    {

        $process = new Process(['/bin/sh', '/home/mohamed/telco-churn-project/public/test.sh']);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }


        $response = strlen($process->getOutput()) > 1 ? "Le container avec l'ID ".$process->getOutput()." a été créé avec succès.": "Une erreur s'est produite." ;
        dump($response);
        exit;
    }
    /**
     * @Route("/test", name="test")
     */
    public function index(KernelInterface $kernel, Request $request)
    {


        //dump(MessageTypeEnum::getAvailableTypes());

        /*$result ="";
        //Parameters
        $fields = array(
           ['field' => 'nomeleve', 'type' => 'string', 'length' => 255, 'nullable' => true],
           ['field' => 'prenomeleve', 'type' => 'string', 'length' => 255, 'nullable' => true],
           ['field' => 'lieunaissance', 'type' => 'string', 'length' => 255, 'nullable' => true],
           ['field' => 'ageeleve', 'type' => 'float', 'nullable' => true],
           ['field' => 'total', 'type' => 'float', 'nullable' => true],
           ['field' => 'classe', 'type' => 'String', 'length' => 255, 'nullable' => true],
           ['field' => 'tata', 'type' => 'String', 'length' => 255, 'nullable' => true],
        );

        $entityMaker = new EntityMaker("Eleve", $fields, new Filesystem(), $kernel);


        $generationResult = $entityMaker->buildEntity();


        if($generationResult['EntityFileIsGenerated'] == True & $generationResult['EntityFileIsGenerated'] == True){
            $result = "L'entité et le repository de l'entité ont été créés avec succès";
        }else{
            //$entityMaker->abortGeneration();
        }*/


        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($form->getData());
            exit;
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('dataset_index');
        }

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/test/prediction", name="test")
     */

    public function prediction(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('colonne1',NumberType::class, [])
            ->add('colonne2', DateType::class, [])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            dump($form->getData());exit;
        }

         //dump($list_dir);exit;
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView(),
        ]);


    }

    /**
     * @Route("/test/osms", name="osms")
     */

    public function sendosmsapi()
    {
        dump($this->getParameter('project_path'));
        exit;
        $credential = array(
        'clientId' => 'LpP9LhhfTABheIGkwXdkBmBYGIQIGR6w',
        'clientSecret' => 'QjNcZkggHUiwr3Z2'
    );

        $osms = new Osms($credential);


        $token = $osms->getTokenFromConsumerKey();


        $result = $osms->sendSMS('tel:+243824109491',
            'tel:+243824109491',
            'Bonjour Goms',
            'Informagenie'
        );
        dump($result);
        exit;

        //dump($list_dir);exit;
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'form' => $form->createView(),
        ]);

    }





}
