<?php

namespace App\Tests\Controllers;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReadingControllerTest extends WebTestCase
{
    protected static function getKernelClass(): string
    {
        return \App\Kernel::class;
    }

    /**
     * @covers \App\Controller\ReadingController::index
     */
    public function testReadingPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reading');

        // Assert that the response status code is 200
        $this->assertResponseIsSuccessful();

        // Assert that the "controller_name" is displayed on the page
        $this->assertSelectorTextContains('body', 'Bibliothèque');
    }

    /**
     * @covers \App\Controller\ReadingController::index
     */
    public function testReadingPageContent()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reading');

        // Assert that the response status code is 200
        $this->assertResponseStatusCodeSame(200);

        // Assert that the rendered view contains the expected text
        $this->assertStringContainsString('Bibliothèque', $client->getResponse()->getContent());
    }
}