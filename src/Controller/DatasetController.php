<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Form\DatasetType;
use App\Repository\DatasetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/export", name="dataset_export")
     */
    public function export(DatasetRepository $repository)
    {
        $spreadsheet = new Spreadsheet();
        $i = 2;

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "#");
        $sheet->setCellValue('B1', 'Gender');
        $sheet->setCellValue('C1', 'Senior citizen');
        $sheet->setCellValue('D1', 'Partner');
        $sheet->setCellValue('E1', 'Dependents');
        $sheet->setCellValue('F1', 'Phone service');
        $sheet->setCellValue('G1', 'Multiple lines');
        $sheet->setCellValue('H1', 'Internet service');
        $sheet->setCellValue('I1', 'Online security');
        $sheet->setCellValue('J1', 'Online backup');
        $sheet->setCellValue('K1', 'Device protection');
        $sheet->setCellValue('L1', 'Tech support');
        $sheet->setCellValue('M1', 'Streaming TV');
        $sheet->setCellValue('N1', 'Streaming movies');
        $sheet->setCellValue('O1', 'Contract');
        $sheet->setCellValue('P1', 'Paperless billing');
        $sheet->setCellValue('Q1', 'Payment method');
        $sheet->setCellValue('R1', 'Tenure');
        $sheet->setCellValue('S1', 'Monthly charges');
        $sheet->setCellValue('T1', 'Total charges');
        $sheet->setCellValue('U1', 'Churn');

        foreach ($repository->findAll() as $data){
            $sheet->setCellValue('A'.$i, $i-1);
            $sheet->setCellValue('B'.$i, $data->getGender());
            $sheet->setCellValue('C'.$i, 'Hello World 3!');
            $sheet->setCellValue('D'.$i, 'Hello World 4!');
            $sheet->setCellValue('E'.$i, 'Hello World 4!');
            $sheet->setCellValue('F'.$i, 'Hello World 4!');
            $sheet->setCellValue('G'.$i, 'Hello World 4!');
            $sheet->setCellValue('H'.$i, 'Hello World 4!');
            $sheet->setCellValue('I'.$i, 'Hello World 4!');
            $sheet->setCellValue('J'.$i, 'Hello World 4!');
            $sheet->setCellValue('K'.$i, 'Hello World 4!');
            $sheet->setCellValue('L'.$i, 'Hello World 4!');
            $sheet->setCellValue('M'.$i, 'Hello World 4!');
            $sheet->setCellValue('N'.$i, 'Hello World 4!');
            $sheet->setCellValue('O'.$i, 'Hello World 4!');
            $sheet->setCellValue('P'.$i, 'Hello World 4!');
            $sheet->setCellValue('Q'.$i, 'Hello World 4!');
            $sheet->setCellValue('R'.$i, 'Hello World 4!');
            $sheet->setCellValue('S'.$i, 'Hello World 4!');
            $sheet->setCellValue('T'.$i, 'Hello World 4!');
            $sheet->setCellValue('U'.$i, 'Hello World 4!');

            $i++;
        }

        $sheet->setTitle("Telco Churn DATASET");

        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);

        // Create a Temporary file in the system
        $fileName = 'telco_churn_dataset.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);

    }

    /**
     * @Route("/", name="dataset_index", methods={"GET"})
     */
    public function index(DatasetRepository $datasetRepository): Response
    {
        return $this->render('dataset/index.html.twig', [
            'datasets' => $datasetRepository->findAll(),
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
