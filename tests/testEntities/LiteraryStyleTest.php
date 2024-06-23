<?php

namespace App\Tests\TestEntities;

use App\Entity\LiteraryStyle;
use PHPUnit\Framework\TestCase;

/**
 * @covers LiteraryStyle
 */
class LiteraryStyleTest extends TestCase
{
    public function test_literaryStyleIsValid(): void
    {
        $literaryStyle = new LiteraryStyle();

        $literaryStyle->setName('Thriller');

        $this->assertEquals('Thriller', $literaryStyle->getName());
        
    }

    public function test_literaryStyleIsInvalid(): void
    {
        $literaryStyle = new LiteraryStyle();

        $literaryStyle->setName('Thriller');

        $this->assertNotEmpty('Thriller', $literaryStyle->getName());

        $literaryStyle->setName('');
        $this->assertEmpty($literaryStyle->getName());
    }
}