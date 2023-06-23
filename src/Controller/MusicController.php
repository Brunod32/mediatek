<?php

namespace App\Controller;

use App\Repository\BandRepository;
use App\Repository\AlbumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends AbstractController
{
    #[Route('/music', name: 'app_music')]
    public function index(BandRepository $bandRepository, AlbumRepository $albumRepository): Response
    {
        $nbBand = $bandRepository->bandsCount();
        $nbAlbum = $albumRepository->albumsCount();

        return $this->render('music/index.html.twig', [
            'nbBand' => $nbBand,
            'nbAlbum' => $nbAlbum,
        ]);
    }
}
