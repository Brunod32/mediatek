<?php

namespace App\Tests\TestEntities;

use App\Entity\Band;
use App\Entity\Country;
use App\Entity\Writer;
use PHPUnit\Framework\TestCase;

/**
 * @covers Country
 */
class CountryTest extends TestCase
{
    public function test_countryIsValid(): void
    {
        $country = new Country();
        $band = new Band();
        $band->setName('Gojira');
        $writer = new Writer;
        $writer->setLastname('Thilliez');

        $country->setName('France');
        $country->getBands()->add($band);
        $country->getWriters()->add($writer);

        $this->assertEquals('France', $country->getName());
        $this->assertCount(1, $country->getBands());
        $this->assertEquals('Gojira', $country->getBands()->first()->getName());
        $this->assertCount(1, $country->getWriters());
        $this->assertEquals('Thilliez', $country->getWriters()->first()->getLastname());
    }

    public function test_countryIsInvalid(): void
    {
        $country = new Country();
        $band = new Band();
        $band->setName('Gojira');
        $writer = new Writer;
        $writer->setLastname('Thilliez');
        $country->setName('France');
        $country->getBands()->add($band);
        $country->getWriters()->add($writer);

        // Assertions pour vérifier que les valeurs sont définies
        $this->assertNotEmpty($country->getName('France'));
        $this->assertNotEmpty($country->getBands());
        $this->assertNotEmpty($country->getWriters());
    
        // Cas 1: Nom du pays manquant (chaîne vide)
        $country->setName('');
        $this->assertEmpty($country->getName());

        // Cas 2: Aucun groupe dans le pays
        $country->getBands()->clear();
        $this->assertCount(0, $country->getBands());

        // Cas 3: Aucun écrivain dans le pays
        $country->getWriters()->clear();
        $this->assertCount(0, $country->getWriters());

        // Cas 4: Groupe avec un nom manquant (chaîne vide)
        $band->setName('');
        $country->getBands()->add($band);
        $this->assertEmpty($country->getBands()->first()->getName());
        
        // Cas 5: Écrivain avec un nom de famille manquant (chaîne vide)
        $writer->setLastname('');
        $country->getWriters()->add($writer);
        $this->assertEmpty($country->getWriters()->first()->getLastname());

    }
}