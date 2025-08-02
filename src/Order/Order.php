<?php

namespace Order;

class Order implements OrderInterface
{
    /** @var OrderItemInterface[] */
    private array $items = [];

    public function calculateTotalSum(): float {
        return array_reduce($this->items, fn($sum, $item) => $sum + $item->getTotal(), 0);
    }

    public function getItems(): array {
        return $this->items;
    }

    public function getItemsCount(): int {
        return count($this->items);
    }

    public function addItem(OrderItemInterface $item): void {
        foreach ($this->items as $existing) {
            if ($existing->getId() === $item->getId()) {
                throw new \LogicException("Item already in order");
            }
        }
        $this->items[] = $item;
    }

    public function deleteItem(OrderItemInterface $item): void {
        $this->items = array_filter($this->items, fn($i) => $i->getId() !== $item->getId());
    }

    public function printOrder(): string {
        return json_encode($this->showOrder(), JSON_PRETTY_PRINT);
    }

    public function showOrder(): array {
        return [
            'items' => array_map(fn($i) => [
                'id' => $i->getId(),
                'name' => $i->getName(),
                'quantity' => $i->getQuantity(),
                'price' => $i->getPrice(),
                'total' => $i->getTotal()
            ], $this->items),
            'total' => $this->calculateTotalSum()
        ];
    }

    public function load(): void {
        // Load from storage (stub)
    }

    public function save(): void {
        // Save to storage (stub)
    }

    public function update(): void {
        // Update order in storage (stub)
    }

    public function delete(): void {
        $this->items = [];
    }
}
