<?php

namespace App\Controller;

use App\Entity\LiteraryStyle;
use App\Form\LiteraryStyleType;
use App\Repository\LiteraryStyleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LiteraryStyleController extends AbstractController
{
    #[Route('/literary-style', name: 'app_literary_style_index', methods: ['GET'])]
    public function index(LiteraryStyleRepository $literaryStyleRepository): Response
    {
        return $this->render('literary_style/index.html.twig', [
            'literary_styles' => $literaryStyleRepository->findAll(),
        ]);
    }

    #[Route('admin/literary-style/new', name: 'app_literary_style_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $literaryStyle = new LiteraryStyle();
        $form = $this->createForm(LiteraryStyleType::class, $literaryStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($literaryStyle);
            $entityManager->flush();

            return $this->redirectToRoute('app_literary_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('literary_style/new.html.twig', [
            'literary_style' => $literaryStyle,
            'form' => $form,
        ]);
    }

    #[Route('/literary-style/{id}', name: 'app_literary_style_show', methods: ['GET'])]
    public function show(LiteraryStyle $literaryStyle): Response
    {
        return $this->render('literary_style/show.html.twig', [
            'literary_style' => $literaryStyle,
        ]);
    }

    #[Route('admin/literary-style/{id}/edit', name: 'app_literary_style_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, LiteraryStyle $literaryStyle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LiteraryStyleType::class, $literaryStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_literary_style_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('literary_style/edit.html.twig', [
            'literary_style' => $literaryStyle,
            'form' => $form,
        ]);
    }

    #[Route('admin/literary-style/{id}', name: 'app_literary_style_delete', methods: ['POST'])]
    public function delete(Request $request, LiteraryStyle $literaryStyle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$literaryStyle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($literaryStyle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_literary_style_index', [], Response::HTTP_SEE_OTHER);
    }
}
