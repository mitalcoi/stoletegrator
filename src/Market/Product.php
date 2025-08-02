<?php

namespace Market;

namespace Market;

class Product
{
    /** @var ProductImage[] */
    private array $images = [];

    public function __construct(private readonly ImageStorageInterface $storage) {}

    public function addImage(string $fileName): void
    {
        $this->images[] = new ProductImage($fileName, $this->storage);
    }

    /**
     * @return ProductImage[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    public function getImageUrls(): array
    {
        return array_filter(array_map(
            fn(ProductImage $img) => $img->getUrl(),
            $this->images
        ));
    }
}

