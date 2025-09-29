<?php

namespace App\Controller;

use App\Entity\Marque;
use App\Form\MarqueType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/marque')]
class MarqueController extends AbstractController
{
    #[Route('/', name: 'app_marque_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $marques = $entityManager
            ->getRepository(Marque::class)
            ->findBy([], ['idMarque' => 'DESC'], 25);

        return $this->render('marque/index.html.twig', [
            'marques' => $marques,
        ]);
    }

    #[Route('/new', name: 'app_marque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($marque);
            $entityManager->flush();

              // Génération du message d'information
          $this->addFlash(
            'success',
            $translator->trans('La Marque a bien été ajoutée !')
          );

            return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('marque/new.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{idMarque}', name: 'app_marque_show', methods: ['GET'])]
    public function show(Marque $marque): Response
    {
        return $this->render('marque/show.html.twig', [
            'marque' => $marque,
        ]);
    }

    #[Route('/{idMarque}/edit', name: 'app_marque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Marque $marque, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            // Génération du message d'information
            $this->addFlash(
            'info',
            $translator->trans('La Marque a bien été modifiée !')
             );

            return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('marque/edit.html.twig', [
            'marque' => $marque,
            'form' => $form,
        ]);
    }

    #[Route('/{idMarque}', name: 'app_marque_delete', methods: ['POST'])]
    public function delete(Request $request, Marque $marque, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$marque->getIdMarque(), $request->request->get('_token'))) {
            $entityManager->remove($marque);
            $entityManager->flush();

            // Génération du message d'information
            $this->addFlash(
            'danger',
            $translator->trans('La Marque a bien été supprimée !')
             );
        }

        return $this->redirectToRoute('app_marque_index', [], Response::HTTP_SEE_OTHER);
    }
}
