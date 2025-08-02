<?php

namespace Tests\Ticket;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Schema\Schema;
use PHPUnit\Framework\TestCase;
use Ticket\Repository\DbTicketRepository;
use Ticket\Ticket;

class DbTicketRepositoryTest extends TestCase
{
    private \Doctrine\DBAL\Connection $connection;
    private DbTicketRepository $repository;

    protected function setUp(): void
    {
        // SQLite in-memory database
        $this->connection = DriverManager::getConnection([
            'url' => 'sqlite:///:memory:',
        ]);

        $this->createSchema();

        $this->repository = new DbTicketRepository($this->connection);
    }

    private function createSchema(): void
    {
        $schema = new Schema();
        $table = $schema->createTable('tickets');
        $table->addColumn('id', 'integer');
        $table->addColumn('title', 'string');
        $table->addColumn('status', 'string');
        $table->setPrimaryKey(['id']);

        foreach ($schema->toSql($this->connection->getDatabasePlatform()) as $sql) {
            $this->connection->executeStatement($sql);
        }
    }

    public function testSaveAndLoad(): void
    {
        $ticket = new Ticket(1, 'Test', 'open');
        $this->repository->save($ticket);

        $loaded = $this->repository->load(1);

        $this->assertInstanceOf(Ticket::class, $loaded);
        $this->assertSame('Test', $loaded->title);
        $this->assertSame('open', $loaded->status);
    }

    public function testUpdate(): void
    {
        $ticket = new Ticket(2, 'Old Title', 'open');
        $this->repository->save($ticket);

        $ticket->title = 'Updated Title';
        $ticket->status = 'closed';
        $this->repository->update($ticket);

        $loaded = $this->repository->load(2);

        $this->assertSame('Updated Title', $loaded->title);
        $this->assertSame('closed', $loaded->status);
    }

    public function testDelete(): void
    {
        $ticket = new Ticket(3, 'To Delete', 'open');
        $this->repository->save($ticket);

        $this->repository->delete($ticket);
        $this->assertNull($this->repository->load(3));
    }
}
