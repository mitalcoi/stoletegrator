<?php

namespace Market;

use AwsS3\AwsStorageInterface;
use Product\Entity\Product;

class ProductImageService
{
    public function __construct(
//        private FileStorageRepository $localStorage,
        private AwsStorageInterface $awsStorage
    ) {}

    public function getImageUrls(Product $product): array
    {
        $urls = [];
        foreach ($product->getImages() as $image) {
            try {
                $urls[] = (string)$this->awsStorage->getUrl($image->getUrl());
            } catch (\Exception $e) {
                // fallback or log
            }
        }
        return $urls;
    }
}
