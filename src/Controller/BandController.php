<?php

namespace App\Controller;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{
    #[Route('/band/', name: 'app_band_index', methods: ['GET'])]
    public function index(BandRepository $bandRepository): Response
    {
        return $this->render('band/index.html.twig', [
            'bands' => $bandRepository->sortFindAll(),
        ]);
    }

    #[Route('/admin/band/new', name: 'app_band_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BandRepository $bandRepository): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bandRepository->save($band, true);

            return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('band/new.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('/band/{id}', name: 'app_band_show', methods: ['GET'])]
    public function show(Band $band, BandRepository $bandRepository): Response
    {
        // Afficher les groupes du même genre de métal que la page du groupe
        $styleOfMetalParam = $band->getStyle();
        $allBands = $bandRepository->findAll();
        
        return $this->render('band/show.html.twig', [
            'band' => $band,
            'allBands' => $allBands,
            'styleOfMetal' => $styleOfMetalParam,
        ]);
    }

    #[Route('admin/band/{id}/edit', name: 'app_band_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bandRepository->save($band, true);

            return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('admin/band/{id}', name: 'app_band_delete', methods: ['POST'])]
    public function delete(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$band->getId(), $request->request->get('_token'))) {
            $bandRepository->remove($band, true);
        }

        return $this->redirectToRoute('app_band_index', [], Response::HTTP_SEE_OTHER);
    }
}
