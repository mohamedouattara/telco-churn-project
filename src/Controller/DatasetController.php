<?php

namespace App\Controller;

use App\Entity\Dataset;
use App\Form\DatasetType;
use App\Repository\DatasetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dataset")
 */
class DatasetController extends AbstractController
{
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
