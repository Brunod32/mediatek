<?php

namespace App\Tests\Controllers;

use App\Entity\Country;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;

class CountryControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers Country::add
     */
    public function testNewCountry()
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

        // Faire une requête POST à l'URL /admin/country/new
        $crawler = $client->request('POST', '/admin/country/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de pays dans la réponse HTML
        $form = $crawler->filter('form[name=country]')->form();

        // Remplir les champs du formulaire
        $form['country[name]'] = 'France';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /country/
        $this->assertResponseRedirects('/country');
    }

    /**
     * @covers Country::edit
     */
    public function testEditCountry()
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

        // Choisir un ID spécifique pour le test
        $countryId = 1; 
        $country = $entityManager->getRepository(Country::class)->find($countryId);

        // Vérifier que le pays existe
        $this->assertNotNull($countryId, 'Le pays avec l\'ID ' . $countryId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête GET à l'URL /admin/country/{id}/edit pour accéder à la page de modification
        $crawler = $client->request('GET', '/admin/country/' . $countryId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=country]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['country[name]'] = 'USA';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /country
        $this->assertResponseRedirects('/country');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedCountry = $entityManager->getRepository(Country::class)->find($countryId);
        $this->assertSame('USA', $updatedCountry->getName(), 'Le pays n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers Country::delete
     */
    public function testDeleteCountry()
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

        // Choisir un ID spécifique pour le test
        $countryId = 3;
        $country = $entityManager->getRepository(Country::class)->find($countryId);

        // Vérifier que le pays existe
        $this->assertNotNull($country, 'Le pays avec l\'ID ' . $countryId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le pays
        $client->request('POST', '/admin/country/' . $countryId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /country
        $this->assertResponseRedirects('/country');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();
    }
}