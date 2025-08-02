<?php

namespace Product\View;

use Product\Entity\Product;
use Product\Entity\ProductImage;
use Product\Entity\User;
use Product\View\Dto\ProductView;

class ProductViewFactory
{
    public function create(Product $product, ?User $user): ProductView
    {
        return new ProductView(
            id: $product->getId(),
            name: $product->getName(),
            description: $product->getDescription(),
            category: $product->getCategory(),
            images: array_map(fn(ProductImage $img) => $img->getUrl(), $product->getImages()),
            isFavorite: $user !== null && $product->isFavoriteForUser($user),
        );
    }

    /**
     * @param Product[] $products
     * @return ProductView[]
     */
    public function createList(array $products, ?User $user): array
    {
        return array_map(fn(Product $p) => $this->create($p, $user), $products);
    }
}
