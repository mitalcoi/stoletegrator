<?php

namespace Ticket\Repository;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Ticket\Ticket;

class ApiTicketRepository implements TicketRepositoryInterface
{
    private string $apiUrl = 'https://external-ticket.api/tickets';

    public function __construct(private HttpClientInterface $client, private LoggerInterface $logger) {}

    public function load(int $id): ?Ticket
    {
        try {
            $response = $this->client->request('GET', "$this->apiUrl/$id");
            if ($response->getStatusCode() !== Response::HTTP_OK) {
                return null;
            }
            $data = $response->toArray();
            return new Ticket($data['id'], $data['title'], $data['status']);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
            return null;
        }
    }

    public function save(Ticket $ticket): void
    {
        try {
            $this->client->request('POST', $this->apiUrl, [
                'json' => [
                    'id' => $ticket->id,
                    'title' => $ticket->title,
                    'status' => $ticket->status,
                ]
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function update(Ticket $ticket): void
    {
        try {
            $this->client->request('PUT', "$this->apiUrl/{$ticket->id}", [
                'json' => [
                    'title' => $ticket->title,
                    'status' => $ticket->status,
                ]
            ]);
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function delete(Ticket $ticket): void
    {
        try {
            $this->client->request('DELETE', "$this->apiUrl/{$ticket->id}");
        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
