<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\Band;
use App\Entity\User;

class BandControllerTest extends WebTestCase
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
     * @covers Band::add
     */
    public function testNewBand()
    {
        // Faire une requête POST à l'URL /admin/band/new
        $crawler = $this->client->request('POST', '/admin/band/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de pays dans la réponse HTML
        $form = $crawler->filter('form[name=band]')->form();

        // Remplir les champs du formulaire
        $form['band[name]'] = 'Metallica';
        $form['band[picture]'] = 'Lajoliephoto';
        $form['band[creationYear]'] = '1981';
        $form['band[country]'] = '1';
        $form['band[style]'] = '5';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /band/
        $this->assertResponseRedirects('/band/');
    }

    /**
     * @covers Band::edit
     */
    public function testEditBand()
    {
        // Choisir un ID spécifique pour le test
        $bandId = 1;

        // Faire une requête GET à l'URL /admin/band/{id}/edit pour accéder à la page de modification
        $crawler = $this->client->request('GET', '/admin/band/' . $bandId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=band]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['band[name]'] = 'Metallica';
        $form['band[picture]'] = 'Lajoliephoto';
        $form['band[creationYear]'] = '1981';
        $form['band[country]'] = '2';
        $form['band[style]'] = '8';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /band/
        $this->assertResponseRedirects('/band/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedBand = $this->entityManager->getRepository(Band::class)->find($bandId);
        $this->assertSame('Metallica', $updatedBand->getName(), 'Le groupe n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers Band::delete
     */
    public function testDeleteBand()
    {
        // Choisir un ID spécifique pour le test
        $bandId = 10;
        $band = $this->entityManager->getRepository(Band::class)->find($bandId);

        // Vérifier que le pays existe
        $this->assertNotNull($band, 'Le groupe avec l\'ID ' . $bandId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le groupe
        $this->client->request('POST', '/admin/band/' . $bandId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /band
        $this->assertResponseRedirects('/band/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();
    }
}