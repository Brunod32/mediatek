<?php

namespace App\Controller;

use App\Entity\MetalStyle;
use App\Form\MetalStyleType;
use App\Repository\MetalStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MetalStyleController extends AbstractController
{
    #[Route('/metal-style', name: 'app_metal_style_index', methods: ['GET'])]
    public function index(MetalStyleRepository $metalStyleRepository): Response
    {
        return $this->render('metal_style/index.html.twig', [
            'metal_styles' => $metalStyleRepository->findAll(),
        ]);
    }

    #[Route('admin/metal-style/new', name: 'app_metal_style_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $metalStyle = new MetalStyle();
        $form = $this->createForm(MetalStyleType::class, $metalStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($metalStyle);
            $entityManager->flush();

            return $this->redirectToRoute('app_metal_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('metal_style/new.html.twig', [
            'metal_style' => $metalStyle,
            'form' => $form,
        ]);
    }

    #[Route('/metal-style/{id}', name: 'app_metal_style_show', methods: ['GET'])]
    public function show(MetalStyle $metalStyle): Response
    {
        return $this->render('metal_style/show.html.twig', [
            'metal_style' => $metalStyle,
        ]);
    }

    #[Route('admin/metal-style/{id}/edit', name: 'app_metal_style_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MetalStyle $metalStyle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MetalStyleType::class, $metalStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_metal_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('metal_style/edit.html.twig', [
            'metal_style' => $metalStyle,
            'form' => $form,
        ]);
    }

    #[Route('admin/metal-style/{id}', name: 'app_metal_style_delete', methods: ['POST'])]
    public function delete(Request $request, MetalStyle $metalStyle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$metalStyle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($metalStyle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_metal_style_index', [], Response::HTTP_SEE_OTHER);
    }
}
