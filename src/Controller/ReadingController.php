<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReadingController extends AbstractController
{
    #[Route('/reading', name: 'app_reading')]
    public function index(): Response
    {
        return $this->render('reading/index.html.twig');
    }
}
