<?php

namespace App\Tests\TestEntities;

use App\Entity\Book;
use App\Entity\Country;
use App\Entity\LiteraryStyle;
use App\Entity\Writer;
use PHPUnit\Framework\TestCase;

/**
 * @covers Writer
 */
class WriterTest extends TestCase
{
    public function test_writerIsValid(): void
    {
        $writer = new Writer;
        $country = new Country();
        $literaryStyle = new LiteraryStyle();
        $book = new Book();

        $writer->setFirstname('Franck');
        $writer->setLastname('Thilliez');
        $writer->setPicture('PictureOfFranck');
        $writer->setCountry($country);
        $book->setTitle('La Faille');
        $writer->getBooks()->add($book);

        $this->assertEquals('Franck', $writer->getFirstname());
        $this->assertEquals('Thilliez', $writer->getLastname());
        $this->assertEquals('PictureOfFranck', $writer->getPicture());
        $this->assertSame($country, $writer->getCountry());
        $this->assertCount(1, $writer->getBooks());
        $this->assertEquals('La Faille', $writer->getBooks()->first()->getTitle());
    }

    public function test_writerIsInValid(): void
    {
        $writer = new Writer;
        $country = new Country();
        $literaryStyle = new LiteraryStyle();
        $book = new Book();

        $writer->setFirstname('Franck');
        $writer->setLastname('Thilliez');
        $writer->setPicture('PictureOfFranck');
        $writer->setCountry($country);
        $book->setTitle('La Faille');
        $writer->getBooks()->add($book);

        // Propriétés non vides ou nulles
        $this->assertNotEmpty($writer->getFirstname());
        $this->assertNotEmpty($writer->getLastname());
        $this->assertNotEmpty($writer->getPicture());
        $this->assertNotEmpty($writer->getCountry());
        $this->assertNotEmpty($writer->getBooks());

        // Cas 1: Prénom manquant (chaîne vide)
        $writer->setFirstname('');
        $this->assertEmpty($writer->getFirstname());

        // Cas 2: Nom de famille manquant (chaîne vide)
        $writer->setLastname('');
        $this->assertEmpty($writer->getLastname());

        // Cas 3: Image manquante (chaîne vide)
        $writer->setPicture('');
        $this->assertEmpty($writer->getPicture());

        // Cas 4: Pays manquant (null)
        $writer->setCountry(null);
        $this->assertNull($writer->getCountry());

        // Cas 5: Livres manquants (collection vide)
        $writer->getBooks()->clear();
        $this->assertEmpty($writer->getBooks());
    }

}