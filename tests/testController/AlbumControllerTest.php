<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\Album;
use App\Entity\User;

class AlbumControllerTest extends WebTestCase
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
     * @covers Album::add
     */
    public function testNewAlbum()
    {
        // Faire une requête POST à l'URL /admin/album/new
        $crawler = $this->client->request('POST', '/admin/album/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de pays dans la réponse HTML
        $form = $crawler->filter('form[name=album]')->form();

        // Remplir les champs du formulaire
        $form['album[title]'] = 'Master Of Puppets';
        $form['album[releasedYear]'] = '1986';
        $form['album[albumCover]'] = 'Lajoliephoto';


        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /album/
        $this->assertResponseRedirects('/album/');
    }

    /**
     * @covers Album::edit
     */
    public function testEditAlbum()
    {
        // Choisir un ID spécifique pour le test
        $albumId = 1;

        // Faire une requête GET à l'URL /admin/album/{id}/edit pour accéder à la page de modification
        $crawler = $this->client->request('GET', '/admin/album/' . $albumId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=album]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['album[title]'] = '72 seasons';
        $form['album[releasedYear]'] = '2024';
        $form['album[albumCover]'] = 'Lajoliephoto';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /album/
        $this->assertResponseRedirects('/album/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedAlbum = $this->entityManager->getRepository(Album::class)->find($albumId);
        $this->assertSame('72 seasons', $updatedAlbum->getTitle(), 'L\'album n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers Album::delete
     */
    public function testDeleteAlbum()
    {
        // Choisir un ID spécifique pour le test
        $albumId = 1;
        $album = $this->entityManager->getRepository(Album::class)->find($albumId);

        // Vérifier que le pays existe
        $this->assertNotNull($album, 'L\'album avec l\'ID ' . $albumId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le groupe
        $this->client->request('POST', '/admin/album/' . $albumId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /album
        $this->assertResponseRedirects('/album/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();
    }
}