<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250802124848 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(
            'CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(255) NOT NULL, category VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, url VARCHAR(255) NOT NULL, INDEX IDX_64617F034584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE user_favorites (user_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_E489ED11A76ED395 (user_id), INDEX IDX_E489ED114584665A (product_id), PRIMARY KEY(user_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)'
        );
        $this->addSql(
            'ALTER TABLE user_favorites ADD CONSTRAINT FK_E489ED11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE'
        );
        $this->addSql(
            'ALTER TABLE user_favorites ADD CONSTRAINT FK_E489ED114584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE'
        );

        $this->addSql(
            'CREATE TABLE tickets (
    id INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    status VARCHAR(50) NOT NULL
);'
        ); //for non-mapped Ticket entity
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE user_favorites DROP FOREIGN KEY FK_E489ED11A76ED395');
        $this->addSql('ALTER TABLE user_favorites DROP FOREIGN KEY FK_E489ED114584665A');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_favorites');
        $this->addSql('DROP TABLE tickets');
    }
}
