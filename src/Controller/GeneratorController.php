<?php

namespace App\Controller;

use App\Entity\Champ;
use App\Entity\Table;

use App\Form\ChampType;
use App\Form\TableType;
use App\Services\EntityMaker;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class GeneratorController extends AbstractController
{
    /**
     * @Route("/delete/{table}", name="sanitizer")
     */
    public function tableRemove($table, KernelInterface $kernel)
    {
        $entityMaker = new EntityMaker($table,[],new Filesystem(), $kernel);
        $entityMaker->removeEntity($table);

        return $this->redirectToRoute('dataset_index');
        //dump($table);
        //exit;
    }
    /**
     * @Route("/generator", name="generator")
     */
    public function generate(Request $request, ObjectManager $manager, KernelInterface $kernel)
    {

        $form = $this->createFormBuilder()
            ->add('libelle')
            ->add('champs', CollectionType::class, [
                'entry_type' => ChampType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true,
                //'mapped' => false,
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $tableViewData = $form->getData()['libelle'];
            $champs = $form->getData()['champs'];
            $fields = [];

            $table = new Table();
            $table->setLibelle($tableViewData);

            foreach ($champs as $champ){
                $tmp_str = strtolower(str_replace([' ', '_','-','/','*','#'], '',$champ->getlibelleChamp()));

                if (strtolower($champ->getTypeChamp()) == 'string')
                    array_push($fields, ['field'=> $tmp_str, 'type' => $champ->getTypeChamp(),'length' => 255, 'nullable' => true]);
                elseif (strtolower($champ->getTypeChamp()) == 'integer')
                    array_push($fields, ['field'=> $tmp_str, 'type' => $champ->getTypeChamp(), 'nullable' => true]);

                $table->addChamp($champ);
                //dump($tmp_str);
            }
            //exit;

            $entityMaker = new EntityMaker($tableViewData, $fields, new Filesystem(), $kernel);

            $entityMaker->buildEntity();


            //$manager->persist($table);
            //$manager->flush();

            return $this->redirectToRoute('dataset_index', ['cache_reset' => 1]);

            //dump($table);
            //dump($fields);
            //exit;
        }

        return $this->render('generator/index.html.twig', [
            'controller' => 'generator',
            'form' => $form->createView()
        ]);
    }
}