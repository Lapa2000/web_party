<?php

namespace App\Controller;

use App\Entity\ErpCommandeClient;
use App\Form\ErpCommandeClientType;
use App\Repository\ErpCommandeClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/erp/commande/client')]
class ErpCommandeClientController extends AbstractController
{
    #[Route('/', name: 'app_erp_commande_client_index', methods: ['GET'])]
    public function index(ErpCommandeClientRepository $erpCommandeClientRepository): Response
    {
        return $this->render('erp_commande_client/index.html.twig', [
            'erp_commande_clients' => $erpCommandeClientRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_erp_commande_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $erpCommandeClient = new ErpCommandeClient();
        $form = $this->createForm(ErpCommandeClientType::class, $erpCommandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($erpCommandeClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_commande_client/new.html.twig', [
            'erp_commande_client' => $erpCommandeClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_commande_client_show', methods: ['GET'])]
    public function show(ErpCommandeClient $erpCommandeClient): Response
    {
        return $this->render('erp_commande_client/show.html.twig', [
            'erp_commande_client' => $erpCommandeClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_erp_commande_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ErpCommandeClient $erpCommandeClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ErpCommandeClientType::class, $erpCommandeClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_erp_commande_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('erp_commande_client/edit.html.twig', [
            'erp_commande_client' => $erpCommandeClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_erp_commande_client_delete', methods: ['POST'])]
    public function delete(Request $request, ErpCommandeClient $erpCommandeClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$erpCommandeClient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($erpCommandeClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_erp_commande_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
