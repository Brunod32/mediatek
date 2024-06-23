<?php

namespace App\Tests\TestEntities;

use App\Entity\Album;
use App\Entity\Band;
use App\Entity\Country;
use App\Entity\MetalStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers Band
 */
class BandTest extends TestCase
{
    public function test_bandIsValid(): void
    {
        $band = new Band();
        $country = new Country();
        $metalStyle = new MetalStyle();
        $album = new Album();

        $band->setName('Groupe1');
        $band->setPicture('pictureBand');
        $band->setCreationYear('2024');
        $band->setCountry($country);
        $band->setStyle($metalStyle);
        $album->setTitle('Premier Album');
        $album->setReleasedYear(2024);
        $album->setBand($band);
        $band->getAlbums()->add($album);

        $this->assertEquals('Groupe1', $band->getName());
        $this->assertEquals('2024', $band->getCreationYear());
        $this->assertEquals('pictureBand', $band->getPicture());
        $this->assertSame($country, $band->getCountry());
        $this->assertSame($metalStyle, $band->getStyle());
        // Vérifier que l'album a bien été ajouté
        $this->assertCount(1, $band->getAlbums());
        $this->assertEquals('Premier Album', $band->getAlbums()->first()->getTitle());
    }

    public function test_bandIsInvalid()
    {
        $band = new Band();
        $country = new Country();
        $metalStyle = new MetalStyle();
        $album = new Album();

        // Configurer le groupe avec des valeurs valides
        $band->setName('Groupe1');
        $band->setPicture('pictureBand');
        $band->setCreationYear(2024);
        $band->setCountry($country);
        $band->setStyle($metalStyle);

        // Configurer l'album avec des valeurs valides
        $album->setTitle('Premier Album');
        $album->setReleasedYear(2024);
        $album->setBand($band);

        // Ajouter l'album à la collection d'albums du groupe
        $band->getAlbums()->add($album);

        // Assertions pour vérifier que les valeurs sont définies
        $this->assertNotEmpty($band->getName());
        $this->assertNotEmpty($band->getPicture());
        $this->assertNotEmpty($band->getCreationYear());
        $this->assertNotEmpty($band->getCountry());
        $this->assertNotEmpty($band->getStyle());
        $this->assertNotEmpty($album->getTitle());
        $this->assertNotEmpty($album->getReleasedYear());
        $this->assertNotEmpty($album->getBand());


        // Cas 1: Nom du groupe manquant (chaîne vide)
        $band->setName('');
        $this->assertEmpty($band->getName());

        // Cas 2: Année de création du groupe invalide (valeur négative)
        $band->setCreationYear(-1);
        $this->assertLessThan(0, $band->getCreationYear());

        // Cas 3: Pays du groupe manquant (null)
        $band->setCountry(null);
        $this->assertNull($band->getCountry());

        // Cas 4: Style du groupe manquant (null)
        $band->setStyle(null);
        $this->assertNull($band->getStyle());

        // Cas 5: Titre de l'album manquant (chaîne vide)
        $album->setTitle('');
        $this->assertEmpty($album->getTitle());

        // Cas 6: Année de sortie de l'album invalide (valeur négative)
        $album->setReleasedYear(-1);
        $this->assertLessThan(0, $album->getReleasedYear());

        // Cas 7: Groupe de l'album manquant (null)
        $album->setBand(null);
        $this->assertNull($album->getBand());
    }
}
