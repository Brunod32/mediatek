<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers \App\Controller\HomeController::index
     */
    public function testHomePageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Assert that the response status code is 200
        $this->assertResponseIsSuccessful();

        // Assert that the "controller_name" is displayed on the page
        $this->assertSelectorTextContains('body', 'Gestionnaire de médias');
    }

    /**
     * @covers \App\Controller\HomeController::index
     */
    public function testHomePageContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Assert that the response status code is 200
        $this->assertResponseStatusCodeSame(200);

        // Assert that the rendered view contains the expected text
        $this->assertStringContainsString('Gestionnaire de médias', $client->getResponse()->getContent());
    }
}