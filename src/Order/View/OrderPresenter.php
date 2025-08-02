<?php

namespace Order\View;

use Order\Order;

class OrderPresenter
{
    public function show(Order $order): array
    {
        return [
            'items' => array_map(fn($i) => [
                'id' => $i->getId(),
                'name' => $i->getName(),
                'qty' => $i->getQuantity(),
                'sum' => $i->getTotal()
            ], $order->getItems()),
            'total' => $order->calculateTotalSum(),
            'count' => $order->getItemsCount(),
        ];
    }
}
