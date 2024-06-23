<?php

namespace App\Tests\TestEntities;

use App\Entity\MetalStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers MetalStyle
 */
class MetalStyleTest extends TestCase
{
    public function test_MetalStyleIsValid(): void
    {
        $metalStyle = new MetalStyle();

        $metalStyle->setName('Thrash');

        $this->assertEquals('Thrash', $metalStyle->getName());
        
    }

    public function test_MetalStyleIsInvalid(): void
    {
        $metalStyle = new MetalStyle();

        $metalStyle->setName('Thrash');

        $this->assertNotEmpty('Thrash', $metalStyle->getName());

        $metalStyle->setName('');
        $this->assertEmpty($metalStyle->getName());
    }
}