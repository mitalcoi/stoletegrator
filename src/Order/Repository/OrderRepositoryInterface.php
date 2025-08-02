<?php

namespace Order\Repository;

use Order\Order;

interface OrderRepositoryInterface
{
    public function load(string $id): ?Order;
    public function save(Order $order): void;
    public function update(Order $order): void;
    public function delete(Order $order): void;
}
