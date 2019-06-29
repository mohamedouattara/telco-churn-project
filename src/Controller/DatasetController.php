<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Form\DatasetType;
use App\Repository\ActifRepository;

use App\Repository\DatasetRepository;
use App\Services\EntityMaker;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\PropertyInfo\DoctrineExtractor;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\ResponseHeaderBag;
// Include PhpSpreadsheet required namespaces
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



/**
 * @Route("/dataset")
 */
class DatasetController extends AbstractController
{




    /**
     * @Route("/export/{table}", name="dataset_export")
     */
    public function export(RegistryInterface $registry ,$table)
    {

        $reflectionExtractor = new ReflectionExtractor();
        $doctrineExtractor = new DoctrineExtractor($this->getDoctrine()->getManager());

        $propertyInfo = new PropertyInfoExtractor(
        // List extractors
            [
                $reflectionExtractor,
                $doctrineExtractor
            ],
            // Type extractors
            [
                $doctrineExtractor,
                $reflectionExtractor
            ]
        );

        $excelCell = range('A','Z');

        $classname = '\App\Repository\\'.ucfirst($table).'Repository';
        $repo = new $classname($registry);



        $objects = $repo->findAll();
        $objectsCount = count($objects);
        if ($objectsCount > 0){
            $objectProperties = $propertyInfo->getProperties($objects[0]);
            // $objectPropertiesLen = count($objectProperties);


            // usually you'll want to make sure the user is authenticated first
            $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

            $spreadsheet = new Spreadsheet();


            $sheet = $spreadsheet->getActiveSheet();

            //Excel File generation
            $i = 0; // Selection des lettres de A-Z Colonnes
            foreach ($objectProperties as $property){
                $j = 2; // Selection des Chiffres de 1-N Lignes
                $column = $excelCell[$i];
                $sheet->setCellValue($column.'1', ucfirst($property));
                foreach ($repo->findAll() as $data){
                    $my_getter ='get'.ucfirst($property);
                    $sheet->setCellValue($column.''.$j, $data->$my_getter());
                    $j++;
                }
                $i++;
            }
        }else{
            return $this->redirectToRoute('dataset_index');
        }



        $sheet->setTitle($table." DATASET");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = $table.'_dataset.xlsx';

        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        // Create the excel file in the tmp directory of the system

        $writer->save($temp_file);
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }

    /**
     * @Route("/{cache_reset}", name="dataset_index", methods={"GET"})
     */
    public function index(DatasetRepository $datasetRepository, KernelInterface $kernel, $cache_reset=false): Response
    {
        // returns your User object, or null if the user is not authenticated
        // use inline documentation to tell your editor your exact User class
        // /** @var \App\Entity\User $user */
        // $user = $this->getUser();

        $list_dir = array();
        $entityMaker = new EntityMaker(null, [], new Filesystem(), $kernel);


        if($handle = opendir('../templates')){

            while(false !== ($entry = readdir($handle))){
                if ($entry != "." and $entry != ".." and $entry != "base.html.twig" and $entry != "security" and $entry != "dataset" and $entry != "test" and $entry != 'generator'){
                    array_push($list_dir, $entry);
                }
            }
        }

        if ($cache_reset){
            $entityMaker->commandCacheClear();
            $entityMaker->commandCacheWarmup();
        }


        return $this->render('dataset/index.html.twig', [
            'datasets' => $datasetRepository->findAll(),
            'templates' => $list_dir,
            'controller' => 'dataset_index',
        ]);
    }

    /**
     * @Route("/new", name="dataset_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $dataset = new Dataset();
        $form = $this->createForm(DatasetType::class, $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($dataset);
            $entityManager->flush();

            return $this->redirectToRoute('dataset_index');
        }

        return $this->render('dataset/new.html.twig', [
            'dataset' => $dataset,
            'controller' => 'dataset_new',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dataset_show", methods={"GET"})
     */
    public function show(Dataset $dataset): Response
    {
        return $this->render('dataset/show.html.twig', [
            'dataset' => $dataset,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dataset_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Dataset $dataset): Response
    {
        $form = $this->createForm(DatasetType::class, $dataset);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('dataset_index', [
                'id' => $dataset->getId(),
            ]);
        }

        return $this->render('dataset/edit.html.twig', [
            'dataset' => $dataset,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dataset_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Dataset $dataset): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dataset->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($dataset);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dataset_index');
    }
}
