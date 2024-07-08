<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\Book;
use App\Entity\User;

class BookControllerTest extends WebTestCase
{
    private $client;
    private $entityManager;
    private $user;

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Charger les variables d'environnement depuis le fichier .env.test
        (new Dotenv())->loadEnv(dirname(__DIR__, 2).'/.env.test');

        // Créer un client HTTP pour simuler un navigateur
        $this->client = static::createClient();

        // Récupérer le gestionnaire d'entités (EntityManager) pour accéder à la base de données
        $this->entityManager = $this->client->getContainer()->get('doctrine')->getManager();

        // Trouver un utilisateur existant dans votre base de données de test
        $this->user = $this->entityManager->getRepository(User::class)->findOneByEmail('test@test.fr');

        // Vérifier que l'utilisateur existe
        $this->assertNotNull($this->user, 'L\'utilisateur test@test.fr n\'existe pas dans la base de données de test.');

        // Simuler l'authentification en tant qu'utilisateur existant
        $this->client->loginUser($this->user);
    }

    /**
     * @covers Book::add
     */
    public function testNewBook()
    {
        // Faire une requête POST à l'URL /admin/book/new
        $crawler = $this->client->request('POST', '/admin/book/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de pays dans la réponse HTML
        $form = $crawler->filter('form[name=book]')->form();

        // Remplir les champs du formulaire
        $form['book[title]'] = 'La faille 2';
        $form['book[releasedYear]'] = '2023';
        $form['book[bookCover]'] = 'Lajoliephoto';
        $form['book[nbPages]'] = '450';
        $form['book[synopsis]'] = 'C\'est l\'histoire d\'une enquête de Franck Sharko';
        $form['book[style]'] = '1';
        
        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /book/
        $this->assertResponseRedirects('/book/');
    }

    /**
     * @covers Book::edit
     */
    public function testEditBook()
    {
        // Choisir un ID spécifique pour le test
        $bookId = 1;

        // Faire une requête GET à l'URL /admin/book/{id}/edit pour accéder à la page de modification
        $crawler = $this->client->request('GET', '/admin/book/' . $bookId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=book]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['book[title]'] = 'La faille 3';
        $form['book[releasedYear]'] = '2024';
        $form['book[bookCover]'] = 'Lajoliephoto2';
        $form['book[nbPages]'] = '500';
        $form['book[synopsis]'] = 'C\'est l\'histoire d\'une enquête de Franck Sharko';
        $form['book[style]'] = '1';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /book/
        $this->assertResponseRedirects('/book/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedBook = $this->entityManager->getRepository(Book::class)->find($bookId);
        $this->assertSame('La faille 3', $updatedBook->getTitle(), 'Le livre n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers Book::delete
     */
    public function testDeleteBook()
    {
        // Choisir un ID spécifique pour le test
        $bookId = 1;
        $book = $this->entityManager->getRepository(Book::class)->find($bookId);

        // Vérifier que le pays existe
        $this->assertNotNull($book, 'Le livre avec l\'ID ' . $bookId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le groupe
        $this->client->request('POST', '/admin/book/' . $bookId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /book
        $this->assertResponseRedirects('/book/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();
    }
}