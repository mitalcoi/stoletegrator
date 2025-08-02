<?php

namespace Tests\Order;


use Order\Order;
use Order\OrderItem;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testOrderCalculationAndItemManagement(): void
    {
        $order = new Order();

        $item1 = new OrderItem(1, 'Apple', 2, 3.5);
        $item2 = new OrderItem(2, 'Banana', 1, 2.0);

        $order->addItem($item1);
        $order->addItem($item2);

        $this->assertCount(2, $order->getItems());
        $this->assertEquals(9.0, $order->calculateTotalSum());

        $order->deleteItem($item2);

        $this->assertCount(1, $order->getItems());
        $this->assertEquals(1, $order->getItemsCount());
        $this->assertEquals(7.0, $order->calculateTotalSum());
    }
}
