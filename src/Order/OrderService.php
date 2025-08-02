<?php

namespace Order;

use Order\Repository\OrderRepositoryInterface;
use Order\View\OrderPresenter;

class OrderService
{
    public function __construct(
        private OrderRepositoryInterface $repo,
        private OrderPrinterInterface $printer,
        private OrderPresenter $presenter
    ) {}

    public function load(string $id): ?Order
    {
        return $this->repo->load($id);
    }

    public function save(Order $order): void
    {
        $this->repo->save($order);
    }

    public function update(Order $order): void
    {
        $this->repo->update($order);
    }

    public function delete(Order $order): void
    {
        $this->repo->delete($order);
    }

    public function printOrder(Order $order): string
    {
        return $this->printer->print($order);
    }

    public function showOrder(Order $order): array
    {
        return $this->presenter->show($order);
    }
}
