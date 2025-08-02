<?php

namespace Order;

interface OrderItemInterface {
    public function getId(): int;
    public function getName(): string;
    public function getQuantity(): int;
    public function getPrice(): float;
    public function getTotal(): float;
}
