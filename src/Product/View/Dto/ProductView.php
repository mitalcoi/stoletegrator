<?php

namespace Product\View\Dto;

readonly class ProductView
{
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public string $category,
        /** @var string[] */
        public array $images,
        public bool $isFavorite,
    ) {}
}
