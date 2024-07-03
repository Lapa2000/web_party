<?php

namespace App\Controller;

use App\Entity\AvoirClients;
use App\Form\AvoirClientsType;
use App\Repository\AvoirClientsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/avoir/clients')]
class AvoirClientsController extends AbstractController
{
    #[Route('/', name: 'app_avoir_clients_index', methods: ['GET'])]
    public function index(AvoirClientsRepository $avoirClientsRepository): Response
    {
        return $this->render('avoir_clients/index.html.twig', [
            'avoir_clients' => $avoirClientsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_avoir_clients_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avoirClient = new AvoirClients();
        $form = $this->createForm(AvoirClientsType::class, $avoirClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avoirClient);
            $entityManager->flush();

            return $this->redirectToRoute('app_avoir_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avoir_clients/new.html.twig', [
            'avoir_client' => $avoirClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avoir_clients_show', methods: ['GET'])]
    public function show(AvoirClients $avoirClient): Response
    {
        return $this->render('avoir_clients/show.html.twig', [
            'avoir_client' => $avoirClient,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avoir_clients_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvoirClients $avoirClient, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvoirClientsType::class, $avoirClient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avoir_clients_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avoir_clients/edit.html.twig', [
            'avoir_client' => $avoirClient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avoir_clients_delete', methods: ['POST'])]
    public function delete(Request $request, AvoirClients $avoirClient, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avoirClient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($avoirClient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avoir_clients_index', [], Response::HTTP_SEE_OTHER);
    }
}
