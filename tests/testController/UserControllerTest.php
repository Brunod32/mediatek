<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Dotenv\Dotenv;

class RegisterControllerTest extends WebTestCase
{

    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers User::add
     */
    public function testNewRegister()
    {
        // Charger les variables d'environnement depuis le fichier .env.test
        (new Dotenv())->loadEnv(dirname(__DIR__, 2).'/.env.test');

        // Créer un client HTTP pour simuler un navigateur
        $client = static::createClient();

        // Faire une requête POST à l'URL /register
        $crawler = $client->request('POST', '/register');

        // Vérifier que la réponse HTTP est réussie (statut 2xx)
        $this->assertResponseIsSuccessful();

        // Sélectionner le formulaire d'inscription dans la réponse HTML
        $form = $crawler->filter('form[name=registration_form]')->form();

        // Remplir les champs du formulaire
        $form['registration_form[email]'] = 'john.doe@test.fr';
        $form['registration_form[plainPassword]'] = 'johndoe';

        // Soumettre le formulaire rempli
        $client->submit($form);
    }
}