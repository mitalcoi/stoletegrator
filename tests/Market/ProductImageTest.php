<?php

namespace Tests\Market;

use Market\ImageStorageInterface;
use Market\ProductImage;
use PHPUnit\Framework\TestCase;

class ProductImageTest extends TestCase
{
    public function testGetUrlReturnsCorrectUrlWhenFileExists(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);
        $storage->method('fileExists')->willReturn(true);
        $storage->method('getUrl')->willReturn('https://cdn.example.com/image.jpg');

        $image = new ProductImage('image.jpg', $storage);
        $this->assertEquals('https://cdn.example.com/image.jpg', $image->getUrl());
    }

    public function testGetUrlReturnsNullWhenFileMissing(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);
        $storage->method('fileExists')->willReturn(false);

        $image = new ProductImage('missing.jpg', $storage);
        $this->assertNull($image->getUrl());
    }

    public function testUpdateImageCallsCorrectMethods(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);

        $storage->expects($this->once())->method('fileExists')->willReturn(false);
        $storage->expects($this->once())->method('deleteFile')->with('image.jpg');
        $storage->expects($this->once())->method('saveFile')->with('image.jpg');

        $image = new ProductImage('image.jpg', $storage);
        $this->assertTrue($image->update());
    }

    public function testUpdateReturnsFalseOnException(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);
        $storage->method('fileExists')->willReturn(false);
        $storage->method('deleteFile')->willThrowException(new \Exception());

        $image = new ProductImage('image.jpg', $storage);
        $this->assertFalse($image->update());
    }
}
