<?php

namespace App\Controller;

use App\Entity\ErpFacturesFournisseurNew;
use App\Form\ErpFacturesFournisseurNewType;
use App\Repository\ErpFacturesFournisseurNewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/erp/factures/fournisseur/new')]
class ErpFacturesFournisseurNewController extends AbstractController
{
    #[Route('/', name: 'app_erp_factures_fournisseur_new_index', methods: ['GET'])]
    public function index(ErpFacturesFournisseurNewRepository $erpFacturesFournisseurNewRepository): Response
    {
        return $this->render('erp_factures_fournisseur_new/index.html.twig', [
            'erp_factures_fournisseur_news' => $erpFacturesFournisseurNewRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_erp_factures_fournisseur_new_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $erpFacturesFournisseurNew = new ErpFacturesFournisseurNew();
        $form = $this->createForm(ErpFacturesFournisseurNewType::class, $erpFacturesFournisseurNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($erpFacturesFournisseurNew);
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_factures_fournisseur_new_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_factures_fournisseur_new/new.html.twig', [
            'erp_factures_fournisseur_new' => $erpFacturesFournisseurNew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_factures_fournisseur_new_show', methods: ['GET'])]
    public function show(ErpFacturesFournisseurNew $erpFacturesFournisseurNew): Response
    {
        return $this->render('erp_factures_fournisseur_new/show.html.twig', [
            'erp_factures_fournisseur_new' => $erpFacturesFournisseurNew,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_erp_factures_fournisseur_new_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ErpFacturesFournisseurNew $erpFacturesFournisseurNew, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ErpFacturesFournisseurNewType::class, $erpFacturesFournisseurNew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_factures_fournisseur_new_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_factures_fournisseur_new/edit.html.twig', [
            'erp_factures_fournisseur_new' => $erpFacturesFournisseurNew,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_factures_fournisseur_new_delete', methods: ['POST'])]
    public function delete(Request $request, ErpFacturesFournisseurNew $erpFacturesFournisseurNew, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$erpFacturesFournisseurNew->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($erpFacturesFournisseurNew);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_erp_factures_fournisseur_new_index', [], Response::HTTP_SEE_OTHER);
    }
}
