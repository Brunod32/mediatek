<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;
use App\Entity\Writer;

class WriterControllerTest extends WebTestCase
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
     * @covers Writer::add
     */
    public function testNewWriter()
    {
        // Faire une requête POST à l'URL /admin/writer/new
        $crawler = $this->client->request('POST', '/admin/writer/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de pays dans la réponse HTML
        $form = $crawler->filter('form[name=writer]')->form();

        // Remplir les champs du formulaire
        $form['writer[firstname]'] = 'Franck';
        $form['writer[lastname]'] = 'Thilliez';
        $form['writer[picture]'] = 'Lajoliephoto';
        $form['writer[country]'] = '1';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /writer/
        $this->assertResponseRedirects('/writer/');
    }

    /**
     * @covers Writer::edit
     */
    public function testEditWriter()
    {
        // Choisir un ID spécifique pour le test
        $writerId = 1;

        // Faire une requête GET à l'URL /admin/writer/{id}/edit pour accéder à la page de modification
        $crawler = $this->client->request('GET', '/admin/writer/' . $writerId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=writer]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['writer[firstname]'] = 'Maxime';
        $form['writer[lastname]'] = 'Chattam';
        $form['writer[picture]'] = 'LaSuperjoliephoto';
        $form['writer[country]'] = '2';

        // Soumettre le formulaire rempli
        $this->client->submit($form);

        // Vérifier que la réponse redirige vers /writer/
        $this->assertResponseRedirects('/writer/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedWiter = $this->entityManager->getRepository(Writer::class)->find($writerId);
        $this->assertSame('Chattam', $updatedWiter->getLastname(), 'L\'auteur n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers Writer::delete
     */
    public function testDeleteWriter()
    {
        // Choisir un ID spécifique pour le test
        $writerId = 1;
        $writer = $this->entityManager->getRepository(Writer::class)->find($writerId);

        // Vérifier que le pays existe
        $this->assertNotNull($writer, 'L\'auteur avec l\'ID ' . $writerId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le groupe
        $this->client->request('POST', '/admin/writer/' . $writerId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /writer
        $this->assertResponseRedirects('/writer/');

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $this->entityManager->clear();
    }
}