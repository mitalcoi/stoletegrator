<?php

namespace Order;

interface OrderPrinterInterface
{
    public function print(Order $order): string;
}
