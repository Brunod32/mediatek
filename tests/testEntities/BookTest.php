<?php

namespace App\Tests\TestEntities;

use App\Entity\Book;
use App\Entity\Writer;
use PHPUnit\Framework\TestCase;

/**
 * @covers Book
 */

class BookTest extends TestCase
{
    public function test_bookIsValid(): void
    {
        $book = new Book();
        $writer = new Writer();

        $book->setTitle('La Faille');
        $book->setNbPages(450);
        $book->setBookCover('FailleCover');
        $book->setSynopsis('Le résumé du livre');
        $book->setWriter($writer);

        $this->assertEquals('La Faille', $book->getTitle());
        $this->assertEquals(450, $book->getNbPages());
        $this->assertEquals('FailleCover', $book->getBookCover());
        $this->assertEquals('Le résumé du livre', $book->getSynopsis());
        $this->assertEquals($writer, $book->getWriter());
    }

    public function test_bookIsInvalid(): void
    {
        $book = new Book();
        $writer = new Writer();

        $book->setTitle('La Faille');
        $book->setNbPages(450);
        $book->setBookCover('FailleCover');
        $book->setSynopsis('Le résumé du livre');
        $book->setWriter($writer);

        $this->assertNotEmpty($book->getTitle());
        $this->assertNotEmpty($book->getNbPages());
        $this->assertNotEmpty($book->getBookCover());
        $this->assertNotEmpty($book->getSynopsis());
        $this->assertNotEmpty($book->getWriter());

        // Cas 1: Titre manquant (chaîne vide)
        $book->setTitle('');
        $this->assertEmpty($book->getTitle());

        // Cas 2: Nombre de pages manquant (null)
        $book->setNbPages(null);
        $this->assertNull($book->getNbPages());

        // Cas 3: Couverture manquante (chaîne vide)
        $book->setBookCover('');
        $this->assertEmpty($book->getBookCover());

        // Cas 4: Synopsis manquant (chaîne vide)
        $book->setSynopsis('');
        $this->assertEmpty($book->getSynopsis());

        // Cas 5: Writer manquant (null)
        $book->setWriter(null);
        $this->assertNull($book->getWriter());
    }
}