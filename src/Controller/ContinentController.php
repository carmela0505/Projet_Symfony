<?php

namespace App\Controller;

use App\Entity\Continent;
use App\Form\ContinentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;


#[Route('/continent')]
class ContinentController extends AbstractController
{
    #[Route('/', name: 'app_continent_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $continents = $entityManager
            ->getRepository(Continent::class)
            ->findBy([], ['idContinent' => 'DESC'], 25);

        return $this->render('continent/index.html.twig', [
            'continents' => $continents,
        ]);
    }

    #[Route('/new', name: 'app_continent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $continent = new Continent();
        $form = $this->createForm(ContinentType::class, $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($continent);
            $entityManager->flush();


            // Génération du message d'information
          $this->addFlash(
            'success',
            $translator->trans('Le Continent a bien été ajouté !')
          );

            return $this->redirectToRoute('app_continent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('continent/new.html.twig', [
            'continent' => $continent,
            'form' => $form,
        ]);
    }

    #[Route('/{idContinent}', name: 'app_continent_show', methods: ['GET'])]
    public function show(Continent $continent): Response
    {
        return $this->render('continent/show.html.twig', [
            'continent' => $continent,
        ]);
    }

    #[Route('/{idContinent}/edit', name: 'app_continent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Continent $continent, EntityManagerInterface $entityManager,TranslatorInterface $translator): Response
    {
        $form = $this->createForm(ContinentType::class, $continent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

               // Génération du message d'information
          $this->addFlash(
            'info',
            $translator->trans('Le Continent a bien été modifié !')
          );

            return $this->redirectToRoute('app_continent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('continent/edit.html.twig', [
            'continent' => $continent,
            'form' => $form,
        ]);
    }

    #[Route('/{idContinent}', name: 'app_continent_delete', methods: ['POST'])]
    public function delete(Request $request, Continent $continent, EntityManagerInterface $entityManager, TranslatorInterface $translator): Response
    {
        if ($this->isCsrfTokenValid('delete'.$continent->getIdContinent(), $request->request->get('_token'))) {
            $entityManager->remove($continent);
            $entityManager->flush();

             // Génération du message d'information
          $this->addFlash(
            'danger',
            $translator->trans('Le Continent a bien été supprimé !')
          );
        }

        return $this->redirectToRoute('app_continent_index', [], Response::HTTP_SEE_OTHER);
    }
}
