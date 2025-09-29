<?php

namespace App\Controller;

use App\Entity\Fabricant;
use App\Form\FabricantType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/fabricant')]
class FabricantController extends AbstractController
{
    #[Route('/', name: 'app_fabricant_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager, ): Response
    {
        $fabricants = $entityManager
            ->getRepository(Fabricant::class)
            ->findBy([], ['idFabricant' => 'DESC'], 25);

        return $this->render('fabricant/index.html.twig', [
            'fabricants' => $fabricants,
        ]);
    }

    #[Route('/new', name: 'app_fabricant_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $fabricant = new Fabricant();
        $form = $this->createForm(FabricantType::class, $fabricant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($fabricant);
            $entityManager->flush();

               // Génération du message d'information
          $this->addFlash(
            'success',
            $translator->trans('Le Fabricant a bien été ajouté !')
          );

            return $this->redirectToRoute('app_fabricant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fabricant/new.html.twig', [
            'fabricant' => $fabricant,
            'form' => $form,
        ]);
    }

    #[Route('/{idFabricant}', name: 'app_fabricant_show', methods: ['GET'])]
    public function show(Fabricant $fabricant): Response
    {
        return $this->render('fabricant/show.html.twig', [
            'fabricant' => $fabricant,
        ]);
    }

    #[Route('/{idFabricant}/edit', name: 'app_fabricant_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Fabricant $fabricant, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(FabricantType::class, $fabricant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

                // Génération du message d'information
          $this->addFlash(
            'info',
            $translator->trans('Le Fabricant a bien été modifié !')
          );

            return $this->redirectToRoute('app_fabricant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('fabricant/edit.html.twig', [
            'fabricant' => $fabricant,
            'form' => $form,
        ]);
    }

    #[Route('/{idFabricant}', name: 'app_fabricant_delete', methods: ['POST'])]
    public function delete(Request $request, Fabricant $fabricant, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fabricant->getIdFabricant(), $request->request->get('_token'))) {
            $entityManager->remove($fabricant);
            $entityManager->flush();

             // Génération du message d'information
          $this->addFlash(
            'danger',
            $translator->trans('Le Fabricant a bien été supprimé !')
          );
        }

        return $this->redirectToRoute('app_fabricant_index', [], Response::HTTP_SEE_OTHER);
    }
}
