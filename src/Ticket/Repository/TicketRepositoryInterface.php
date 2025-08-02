<?php

namespace Ticket\Repository;

use Ticket\Ticket;

interface TicketRepositoryInterface
{
    public function load(int $id): ?Ticket;

    public function save(Ticket $ticket): void;

    public function update(Ticket $ticket): void;

    public function delete(Ticket $ticket): void;
}
