<?php

namespace App\Controller;

use App\Entity\Typebiere;
use App\Form\TypebiereType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/typebiere')]
class TypebiereController extends AbstractController
{
    #[Route('/', name: 'app_typebiere_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $typebieres = $entityManager
            ->getRepository(Typebiere::class)
            ->findBy([], ['idType' => 'DESC'], 25);

        return $this->render('typebiere/index.html.twig', [
            'typebieres' => $typebieres,
        ]);
    }

    #[Route('/new', name: 'app_typebiere_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $typebiere = new Typebiere();
        $form = $this->createForm(TypebiereType::class, $typebiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($typebiere);
            $entityManager->flush();

             // Génération du message d'information
          $this->addFlash(
            'success',
            $translator->trans('Le Type de bière a bien été ajouté !')
          );

            return $this->redirectToRoute('app_typebiere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('typebiere/new.html.twig', [
            'typebiere' => $typebiere,
            'form' => $form,
        ]);
    }

    #[Route('/{idType}', name: 'app_typebiere_show', methods: ['GET'])]
    public function show(Typebiere $typebiere): Response
    {
        return $this->render('typebiere/show.html.twig', [
            'typebiere' => $typebiere,
        ]);
    }

    #[Route('/{idType}/edit', name: 'app_typebiere_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Typebiere $typebiere, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(TypebiereType::class, $typebiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

              // Génération du message d'information
          $this->addFlash(
            'info',
            $translator->trans('Le Type de bière a bien été modifié !')
          );

            return $this->redirectToRoute('app_typebiere_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('typebiere/edit.html.twig', [
            'typebiere' => $typebiere,
            'form' => $form,
        ]);
    }

    #[Route('/{idType}', name: 'app_typebiere_delete', methods: ['POST'])]
    public function delete(Request $request, Typebiere $typebiere, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typebiere->getIdType(), $request->request->get('_token'))) {
            $entityManager->remove($typebiere);
            $entityManager->flush();

              // Génération du message d'information
          $this->addFlash(
            'danger',
            $translator->trans('Le Type de bière a bien été supprimé !')
          );
        }

        return $this->redirectToRoute('app_typebiere_index', [], Response::HTTP_SEE_OTHER);
    }
}
