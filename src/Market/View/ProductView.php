<?php

namespace Market\View;

readonly class ProductView
{
    public function __construct(
        public int $id,
        public string $name,
        /**
         * @var string[]
         */
        public array $images,
    ) {}
}
