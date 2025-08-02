<?php

namespace Tests\Market;

use Market\ImageStorageInterface;
use Market\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testAddImageAndRetrieve(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);
        $product = new Product($storage);

        $product->addImage('photo1.jpg');
        $product->addImage('photo2.jpg');

        $images = $product->getImages();
        $this->assertCount(2, $images);
    }

    public function testGetImageUrlsFiltersNulls(): void
    {
        $storage = $this->createMock(ImageStorageInterface::class);

        $storage->method('fileExists')->willReturnMap([
            ['a.jpg', true],
            ['b.jpg', false],
        ]);

        $storage->method('getUrl')->willReturnMap([
            ['a.jpg', 'https://cdn/a.jpg'],
        ]);

        $product = new Product($storage);
        $product->addImage('a.jpg');
        $product->addImage('b.jpg');

        $urls = $product->getImageUrls();
        $this->assertEquals(['https://cdn/a.jpg'], $urls);
    }
}
