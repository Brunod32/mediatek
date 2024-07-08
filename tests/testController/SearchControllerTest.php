<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers \App\Controller\SearchController
     */
    public function testSearch(): void
    {
        // Créer un client HTTP pour simuler un navigateur
        $client = static::createClient();

        // Faire une requête GET avec une chaîne de recherche
        $crawler = $client->request('GET', '/search-results?search=test');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Vérifier que le contenu de la réponse contient des éléments attendus
        $this->assertSelectorTextContains('h1', 'Résultats de la recherche pour :');

        // Vérifier que les données des résultats sont correctement rendues
        $booksSearches = $crawler->filter('.container');
        $this->assertCount(1, $booksSearches);

        $albumsSearches = $crawler->filter('.container');
        $this->assertCount(1, $albumsSearches);

        $bandsSearches = $crawler->filter('.container');
        $this->assertCount(1, $bandsSearches);

        $writersSearches = $crawler->filter('.container');
        $this->assertCount(1, $writersSearches);
    }
}
