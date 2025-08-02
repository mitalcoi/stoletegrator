<?php

namespace Ticket;

class Ticket
{
    public function __construct(
        public int $id,
        public string $title,
        public string $status
    ) {}
}
