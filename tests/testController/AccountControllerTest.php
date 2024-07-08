<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;

class AccountControllerTest extends WebTestCase
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
     * @covers \App\Controller\AccountController::index
     */
    public function testIndex(): void
    {
        // Accéder à la page de compte
        $crawler = $this->client->request('GET', '/account');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Vérifier que le contenu de la réponse contient le texte 'Mon compte'
        $this->assertSelectorTextContains('h1', 'Mon compte');
    }
}
