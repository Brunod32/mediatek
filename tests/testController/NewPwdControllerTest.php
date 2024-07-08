<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class NewPwdControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }
    
    /**
     * @covers \App\Controller\NewPwdControlle::newPwd
     */
    public function testNewPwdFormSubmission(): void
    {
        $client = static::createClient();

        // 1. Accéder à la page de changement de mot de passe pour un utilisateur existant
        $crawler = $client->request('GET', '/user/newpwd/1');

        // 2. Vérifier que la réponse HTTP est réussie
        $this->assertResponseIsSuccessful();

        // 3. Vérifier que le formulaire est rendu dans la réponse
        $form = $crawler->selectButton('Enregistrer')->form();

        // 4. Soumettre le formulaire avec des données valides
        $client->submit($form, [
            'new_pwd[password][first]' => 'newpassword123',
            'new_pwd[password][second]' => 'newpassword123',
        ]);

        // 5. Vérifier la redirection après la soumission du formulaire
        $this->assertResponseRedirects('/user/newpassword-validated');
        $client->followRedirect();

        // 6. Vérifier que la page de validation du nouveau mot de passe est atteinte
        $this->assertSelectorTextContains('h1', 'Nouveau mot de passe valide');
    }
}
