<?php

namespace App\Controller;

use App\Entity\Writer;
use App\Form\WriterType;
use App\Repository\WriterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/writer')]
class WriterController extends AbstractController
{
    #[Route('/', name: 'app_writer_index', methods: ['GET'])]
    public function index(WriterRepository $writerRepository): Response
    {
        return $this->render('writer/index.html.twig', [
            'writers' => $writerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_writer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, WriterRepository $writerRepository): Response
    {
        $writer = new Writer();
        $form = $this->createForm(WriterType::class, $writer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $writerRepository->save($writer, true);

            return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('writer/new.html.twig', [
            'writer' => $writer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_writer_show', methods: ['GET'])]
    public function show(Writer $writer): Response
    {
        return $this->render('writer/show.html.twig', [
            'writer' => $writer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_writer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Writer $writer, WriterRepository $writerRepository): Response
    {
        $form = $this->createForm(WriterType::class, $writer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $writerRepository->save($writer, true);

            return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('writer/edit.html.twig', [
            'writer' => $writer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_writer_delete', methods: ['POST'])]
    public function delete(Request $request, Writer $writer, WriterRepository $writerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$writer->getId(), $request->request->get('_token'))) {
            $writerRepository->remove($writer, true);
        }

        return $this->redirectToRoute('app_writer_index', [], Response::HTTP_SEE_OTHER);
    }
}
