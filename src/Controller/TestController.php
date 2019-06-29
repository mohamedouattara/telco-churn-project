<?php

namespace App\Controller;

use App\Services\EntityMaker;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index(KernelInterface $kernel)
    {



        $result ="";
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
        }




        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'output' => $result,
        ]);
    }

    /**
     * @Route("/repertoire", name="test")
     */
/*
    public function repertoire(){
        $list_dir = array();
        $result ="";
        
       if($handle = opendir('../templates')){

           while(false !== ($entry = readdir($handle))){
               if ($entry != "." and $entry != ".." and $entry != "base.html.twig" and $entry != "security"){
                   array_push($list_dir, $entry);
               }
           }
       }


         //dump($list_dir);
         //exit;

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
            'output' => $result,
            'dirs' => $list_dir,
            'eleves' => "",
            'datasets' => "",

        ]);
    }*/






}
