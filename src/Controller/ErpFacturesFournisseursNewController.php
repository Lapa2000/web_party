<?php

namespace App\Controller;

use App\Entity\ErpFacturesFournisseursNew;
use App\Form\ErpFacturesFournisseursNewType;
use App\Repository\ErpFacturesFournisseursNewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/erp/factures/fournisseurs/new')]
class ErpFacturesFournisseursNewController extends AbstractController
{
    #[Route('/', name: 'app_erp_factures_fournisseurs_new_index', methods: ['GET'])]
    public function index(ErpFacturesFournisseursNewRepository $erpFacturesFournisseursNewRepository): Response
    {
        return $this->render('erp_factures_fournisseurs_new/index.html.twig', [
            'erp_factures_fournisseurs_news' => $erpFacturesFournisseursNewRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_erp_factures_fournisseurs_new_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $erpFacturesFournisseursNew = new ErpFacturesFournisseursNew();
        $form = $this->createForm(ErpFacturesFournisseursNewType::class, $erpFacturesFournisseursNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($erpFacturesFournisseursNew);
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_factures_fournisseurs_new_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_factures_fournisseurs_new/new.html.twig', [
            'erp_factures_fournisseurs_new' => $erpFacturesFournisseursNew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_factures_fournisseurs_new_show', methods: ['GET'])]
    public function show(ErpFacturesFournisseursNew $erpFacturesFournisseursNew): Response
    {
        return $this->render('erp_factures_fournisseurs_new/show.html.twig', [
            'erp_factures_fournisseurs_new' => $erpFacturesFournisseursNew,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_erp_factures_fournisseurs_new_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ErpFacturesFournisseursNew $erpFacturesFournisseursNew, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ErpFacturesFournisseursNewType::class, $erpFacturesFournisseursNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_factures_fournisseurs_new_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_factures_fournisseurs_new/edit.html.twig', [
            'erp_factures_fournisseurs_new' => $erpFacturesFournisseursNew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_factures_fournisseurs_new_delete', methods: ['POST'])]
    public function delete(Request $request, ErpFacturesFournisseursNew $erpFacturesFournisseursNew, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$erpFacturesFournisseursNew->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($erpFacturesFournisseursNew);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_erp_factures_fournisseurs_new_index', [], Response::HTTP_SEE_OTHER);
    }
}
