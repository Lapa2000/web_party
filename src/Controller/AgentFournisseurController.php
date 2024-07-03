<?php

namespace App\Controller;

use App\Entity\AgentFournisseur;
use App\Form\AgentFournisseurType;
use App\Repository\AgentFournisseurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/agent/fournisseur')]
class AgentFournisseurController extends AbstractController
{
    #[Route('/', name: 'app_agent_fournisseur_index', methods: ['GET'])]
    public function index(AgentFournisseurRepository $agentFournisseurRepository): Response
    {
        return $this->render('agent_fournisseur/index.html.twig', [
            'agent_fournisseurs' => $agentFournisseurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_agent_fournisseur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $agentFournisseur = new AgentFournisseur();
        $form = $this->createForm(AgentFournisseurType::class, $agentFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($agentFournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('app_agent_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agent_fournisseur/new.html.twig', [
            'agent_fournisseur' => $agentFournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agent_fournisseur_show', methods: ['GET'])]
    public function show(AgentFournisseur $agentFournisseur): Response
    {
        return $this->render('agent_fournisseur/show.html.twig', [
            'agent_fournisseur' => $agentFournisseur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_agent_fournisseur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AgentFournisseur $agentFournisseur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AgentFournisseurType::class, $agentFournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_agent_fournisseur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('agent_fournisseur/edit.html.twig', [
            'agent_fournisseur' => $agentFournisseur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_agent_fournisseur_delete', methods: ['POST'])]
    public function delete(Request $request, AgentFournisseur $agentFournisseur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$agentFournisseur->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($agentFournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_agent_fournisseur_index', [], Response::HTTP_SEE_OTHER);
    }
}
