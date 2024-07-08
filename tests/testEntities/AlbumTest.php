<?php

namespace App\Tests\TestEntities;

use App\Entity\Album;
use App\Entity\Band;
use PHPUnit\Framework\TestCase;

/**
 * @covers Album
 */
class AlbumTest extends TestCase
{
    public function test_albumIsValid(): void
    {
        $album = new Album();
        $band = new Band();

        $album->setTitle('Album1');
        $album->setReleasedYear('2024');
        $album->setAlbumCover('lacover');
        $album->setBand($band);

        $this->assertEquals('Album1', $album->getTitle());
        $this->assertEquals('2024', $album->getReleasedYear());
        $this->assertEquals('lacover', $album->getAlbumCover());
        $this->assertSame($band, $album->getBand());
    }

    public function test_albumIsInvalid()
    {
        $band = new Band();
        $album = new Album();

        $album->setTitle('Album1');
        $album->setReleasedYear('2024');
        $album->setAlbumCover('lacover');
        $album->setBand($band);

        $this->assertNotEmpty($album->getTitle());
        $this->assertNotEmpty($album->getReleasedYear());
        $this->assertNotEmpty($album->getAlbumCover());
        $this->assertNotEmpty($album->getBand());
    }
}
