<?php

namespace Ticket\Repository;

use Doctrine\DBAL\Connection;
use Ticket\Ticket;

class DbTicketRepository implements TicketRepositoryInterface
{
    public function __construct(private Connection $connection)
    {
    }

    public function load(int $id): ?Ticket
    {
        $data = $this->connection->fetchAssociative('SELECT * FROM tickets WHERE id = :id', [
            'id' => $id,
        ]);

        if (!$data) {
            return null;
        }

        return new Ticket($data['id'], $data['title'], $data['status']);
    }

    public function save(Ticket $ticket): void
    {
        $this->connection->insert('tickets', [
            'id' => $ticket->id,
            'title' => $ticket->title,
            'status' => $ticket->status,
        ]);
    }

    public function update(Ticket $ticket): void
    {
        $this->connection->update('tickets', [
            'title' => $ticket->title,
            'status' => $ticket->status,
        ], ['id' => $ticket->id]);
    }

    public function delete(Ticket $ticket): void
    {
        $this->connection->delete('tickets', ['id' => $ticket->id]);
    }
}
