<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\WriterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReadingController extends AbstractController
{
    #[Route('/reading', name: 'app_reading')]
    public function index(BookRepository $bookRepository, WriterRepository $writerRepository): Response
    {
        $nbBooks = $bookRepository->bookCount();
        $nbWriter = $writerRepository->writerCount();

        return $this->render('reading/index.html.twig', [
            'nbBooks' => $nbBooks,
            'nbWriter' => $nbWriter
        ]);
    }
}
