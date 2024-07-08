<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MusicControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers \App\Controller\MusicController::index
     */
    public function testMusicPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/music');

        // Assert that the response status code is 200
        $this->assertResponseIsSuccessful();

        // Assert that the "controller_name" is displayed on the page
        $this->assertSelectorTextContains('body', 'Librairie musicale');
    }

    /**
     * @covers \App\Controller\MusicController::index
     */
    public function testMusicPageContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/music');

        // Assert that the response status code is 200
        $this->assertResponseStatusCodeSame(200);

        // Assert that the rendered view contains the expected text
        $this->assertStringContainsString('Librairie musicale', $client->getResponse()->getContent());
    }
}