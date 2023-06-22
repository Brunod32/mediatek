<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BandRepository;
use App\Repository\AlbumRepository;
use App\Repository\WriterRepository;
use App\Repository\BookRepository;

class SearchController extends AbstractController
{
    // #[Route('/search', name: 'app_search')]
    // public function index(): Response
    // {
    //     return $this->render('search/index.html.twig', [
    //         'controller_name' => 'SearchController',
    //     ]);
    // }

    #[Route('/search-results', name: 'search-result')]
    public function searchBand(
        Request $request,
        BandRepository $bandRepository,
        AlbumRepository $albumRepository,
        WriterRepository $writerRepository,
        BookRepository $bookRepository
        )
    {
        $search = $request->query->get('search');
        $bandsSearches = $bandRepository->searchBand($search);
        $albumsSearches = $albumRepository->searchAlbum($search);
        $writersSearches = $writerRepository->searchWriter($search);
        $booksSearches = $bookRepository->searchBook($search);

        return $this->render('search/index.html.twig', [
            'bandsSearches' => $bandsSearches,
            'albumsSearches' => $albumsSearches,
            'writersSearches' => $writersSearches,
            'booksSearches' => $booksSearches,
            'search' => $search
        ]);
    }
}
