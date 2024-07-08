<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;
use App\Entity\MetalStyle;

class MetalStyleControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers MetalStyle::add
     */
    public function testNewMetalStyle()
    {
        // Charger les variables d'environnement depuis le fichier .env.test
        (new Dotenv())->loadEnv(dirname(__DIR__, 2).'/.env.test');

        // Créer un client HTTP pour simuler un navigateur
        $client = static::createClient();

        // Récupérer le gestionnaire d'entités (EntityManager) pour accéder à la base de données
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Trouver un utilisateur existant dans votre base de données de test
        $user = $entityManager->getRepository(User::class)->findOneByEmail('test@test.fr');

        // Vérifier que l'utilisateur existe
        $this->assertNotNull($user, 'L\'utilisateur test@test.fr n\'existe pas dans la base de données de test.');

        // Simuler l'authentification en tant qu'utilisateur existant
        $client->loginUser($user);

        // Faire une requête POST à l'URL /admin/metal-style/new
        $crawler = $client->request('POST', '/admin/metal-style/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire d'album dans la réponse HTML
        $form = $crawler->filter('form[name=metal_style]')->form();

        // Remplir les champs du formulaire
        $form['metal_style[name]'] = 'Thrash';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /album/
        $this->assertResponseRedirects('/metal-style');
    }

    /**
     * @covers MetalStyle::edit
     */
    public function testEditMetalStyle()
    {
        // Charger les variables d'environnement depuis le fichier .env.test
        (new Dotenv())->loadEnv(dirname(__DIR__, 2).'/.env.test');

        // Créer un client HTTP pour simuler un navigateur
        $client = static::createClient();

        // Récupérer le gestionnaire d'entités (EntityManager) pour accéder à la base de données
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Trouver un utilisateur existant dans votre base de données de test
        $user = $entityManager->getRepository(User::class)->findOneByEmail('test@test.fr');

        // Vérifier que l'utilisateur existe
        $this->assertNotNull($user, 'L\'utilisateur test@test.fr n\'existe pas dans la base de données de test.');

        // Simuler l'authentification en tant qu'utilisateur existant
        $client->loginUser($user);

        // Choisir un ID spécifique pour le test (assurez-vous que cet ID existe dans la base de données de test)
        $metalStyleId = 5; // ou un autre ID valide
        $metalStyle = $entityManager->getRepository(MetalStyle::class)->find($metalStyleId);

        // Vérifier que le style de métal existe
        $this->assertNotNull($metalStyle, 'Le style de métal avec l\'ID ' . $metalStyleId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête GET à l'URL /admin/metal-style/{id}/edit pour accéder à la page de modification
        $crawler = $client->request('GET', '/admin/metal-style/' . $metalStyleId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=metal_style]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['metal_style[name]'] = 'Heavy Metal';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /metal-style
        $this->assertResponseRedirects('/metal-style');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedMetalStyle = $entityManager->getRepository(MetalStyle::class)->find($metalStyleId);
        $this->assertSame('Heavy Metal', $updatedMetalStyle->getName(), 'Le style de métal n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers MetalStyle::delete
     */
    public function testDeleteMetalStyle()
    {
        // Charger les variables d'environnement depuis le fichier .env.test
        (new Dotenv())->loadEnv(dirname(__DIR__, 2).'/.env.test');

        // Créer un client HTTP pour simuler un navigateur
        $client = static::createClient();

        // Récupérer le gestionnaire d'entités (EntityManager) pour accéder à la base de données
        $entityManager = $client->getContainer()->get('doctrine')->getManager();

        // Trouver un utilisateur existant dans votre base de données de test
        $user = $entityManager->getRepository(User::class)->findOneByEmail('test@test.fr');

        // Vérifier que l'utilisateur existe
        $this->assertNotNull($user, 'L\'utilisateur test@test.fr n\'existe pas dans la base de données de test.');

        // Simuler l'authentification en tant qu'utilisateur existant
        $client->loginUser($user);

        // Choisir un ID spécifique pour le test (assurez-vous que cet ID existe dans la base de données de test)
        $metalStyleId = 6; // ou un autre ID valide
        $metalStyle = $entityManager->getRepository(MetalStyle::class)->find($metalStyleId);

        // Vérifier que le style de métal existe
        $this->assertNotNull($metalStyle, 'Le style de métal avec l\'ID ' . $metalStyleId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le style de métal
        $client->request('POST', '/admin/metal-style/' . $metalStyleId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /metal-style
        $this->assertResponseRedirects('/metal-style');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();
    }

}