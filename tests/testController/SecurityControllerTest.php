<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class SecurityControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers \App\Controller\SecurityController::index
     */
    public function testLogin(): void
    {
        $client = static::createClient();
        
        // Accéder à la page de login
        $crawler = $client->request('GET', '/login');
        
        // Vérifier que la page de login est accessible
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Connexion');
        
        // Soumettre le formulaire de login avec des informations incorrectes
        $form = $crawler->selectButton('Connexion')->form();
        $form['email'] = 'abc@test.fr';
        $form['password'] = '159753654783';
        $client->submit($form);
        
        // Vérifier qu'une erreur de login est affichée
        $crawler = $client->followRedirect();
        $this->assertGreaterThan(
            0,
            $crawler->filter('.alert-danger')->count(),
            'L\'alerte de connexion échouée n\'a pas été affichée.'
        );
        
        // Soumettre le formulaire de login avec des informations correctes
        $form['email'] = 'test@test.fr';
        $form['password'] = '123456789123';
        $client->submit($form);
        
        // Vérifier la redirection après le login
        $this->assertResponseRedirects(''); 
        $client->followRedirect();
    }
    
    /**
     * @covers User
     *
     */
    public function testLogout(): void
    {
        $client = static::createClient();
        
        // Simuler un utilisateur connecté
        $user = $client->getContainer()->get('doctrine')->getRepository(User::class)->findOneByEmail('test@test.fr');
        $this->assertNotNull($user, 'Utilisateur de test non trouvé.');
        $client->loginUser($user);
        
        // Accéder à l'URL de déconnexion
        $client->request('GET', '/logout');
        
        // Vérifier la redirection après la déconnexion
        $this->assertResponseRedirects('');
        $client->followRedirect();
        
        // Vérifier que l'utilisateur est bien déconnecté
        $this->assertSelectorTextContains('h1', 'Gestionnaire de médias');
    }
}
