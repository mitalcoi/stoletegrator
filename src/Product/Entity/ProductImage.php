<?php

namespace Product\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class ProductImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    public function __construct(
        #[ORM\ManyToOne(targetEntity: Product::class, inversedBy: 'images')]
        private Product $product,
        #[ORM\Column(type: 'string')]
        private string $url
    ) {
    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }
}

