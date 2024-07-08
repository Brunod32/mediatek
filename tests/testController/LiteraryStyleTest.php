<?php

namespace App\Tests\Controllers;

use App\Entity\LiteraryStyle;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;
use App\Entity\User;

class LitteraryStyleControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers LiteraryStyle::add
     */
    public function testNewLiteraryStyle()
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

        // Faire une requête POST à l'URL /admin/literary-style/new
        $crawler = $client->request('POST', '/admin/literary-style/new');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de style littéraire dans la réponse HTML
        $form = $crawler->filter('form[name=literary_style]')->form();

        // Remplir les champs du formulaire
        $form['literary_style[name]'] = 'Thriller';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /literary-style/
        $this->assertResponseRedirects('/literary-style');
    }

    /**
     * @covers LiteraryStyle::edit
     */
    public function testEditLiteraryStyle()
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
        $literaryStyleId = 1; 
        $literaryStyle = $entityManager->getRepository(LiteraryStyle::class)->find($literaryStyleId);

        // Vérifier que le style littéraire existe
        $this->assertNotNull($literaryStyleId, 'Le style littéraire avec l\'ID ' . $literaryStyleId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête GET à l'URL /admin/literary-style/{id}/edit pour accéder à la page de modification
        $crawler = $client->request('GET', '/admin/literary-style/' . $literaryStyleId . '/edit');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire de modification dans la réponse HTML
        $form = $crawler->filter('form[name=literary_style]')->form();

        // Remplir les champs du formulaire avec de nouvelles valeurs
        $form['literary_style[name]'] = 'Policier';

        // Soumettre le formulaire rempli
        $client->submit($form);

        // Vérifier que la réponse redirige vers /literary-style
        $this->assertResponseRedirects('/literary-style');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();

        // Vérifier que l'entité a bien été modifiée dans la base de données
        $updatedLiteraryStyle = $entityManager->getRepository(LiteraryStyle::class)->find($literaryStyleId);
        $this->assertSame('Policier', $updatedLiteraryStyle->getName(), 'Le style littéraire n\'a pas été modifié correctement dans la base de données.');
    }

    /**
     * @covers LiteraryStyle::delete
     */
    public function testDeleteLiteraryStyle()
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
        $literaryStyleId = 3;
        $literaryStyle = $entityManager->getRepository(LiteraryStyle::class)->find($literaryStyleId);

        // Vérifier que le style littéraire existe
        $this->assertNotNull($literaryStyle, 'Le style littéraire avec l\'ID ' . $literaryStyleId . ' n\'existe pas dans la base de données de test.');

        // Faire une requête POST à l'URL correspondante pour supprimer le style littéraire
        $client->request('POST', '/admin/literary-style/' . $literaryStyleId);

        // Vérifier que la réponse HTTP est une redirection (statut 303)
        $this->assertResponseStatusCodeSame(303);

        // Vérifier que la réponse redirige vers /literary-style
        $this->assertResponseRedirects('/literary-style');

        // Suivre la redirection
        $client->followRedirect();

        // Rafraîchir l'EntityManager pour obtenir les dernières données de la base de données
        $entityManager->clear();
    }
}