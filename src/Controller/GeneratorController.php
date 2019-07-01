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

            $tableViewData = strtolower(str_replace([' ', '_','-','/','*','#'], '',$form->getData()['libelle']));
           // $tableViewData = strtolower(str_replace(['é', 'è','ê'], 'e',$form->getData()['libelle']));
           // $tableViewData = strtolower(str_replace(['à', 'â','@'], 'a',$form->getData()['libelle']));
            $champs = $form->getData()['champs'];
            $fields = [];

            $table = new Table();
            $table->setLibelle($tableViewData);



            foreach ($champs as $champ){
                $tmp_str = strtolower(str_replace([' ', '_','-','/','*','#'], '',$champ->getlibelleChamp()));
                //$tmp_str = strtolower(str_replace(['é', 'è','ê'], 'e',$champ->getlibelleChamp()));
                //$tmp_str = strtolower(str_replace(['à', 'â','@'], 'a',$champ->getlibelleChamp()));

                if (strtolower($champ->getTypeChamp()) == 'string'){
                    $temp_array = explode(';',$tmp_str);
                    if (count($temp_array) == 1){
                        $tmp_str = $temp_array[0];
                        array_push($fields, ['field'=> $tmp_str, 'type' => $champ->getTypeChamp(),'length' => 255, 'nullable' => true]);
                    } elseif (count($temp_array) > 1){
                        array_push($fields, ['field'=> $temp_array, 'type' => $champ->getTypeChamp(),'length' => 255, 'nullable' => true]);
                    }
                    //Recupére la longueur du tableau après avoir fais un split sur point virgule
                    //Si longueur supérieur à 1 alors construction d'un select sinon traitement normal
                }elseif (strtolower($champ->getTypeChamp()) == 'float')
                    array_push($fields, ['field'=> $tmp_str, 'type' => $champ->getTypeChamp(), 'nullable' => true]);
                elseif (strtolower($champ->getTypeChamp()) == 'datetime')
                    array_push($fields, ['field'=> $tmp_str, 'type' => $champ->getTypeChamp(), 'nullable' => true]);

                $table->addChamp($champ);

            }

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
