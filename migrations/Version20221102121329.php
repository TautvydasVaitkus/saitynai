<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221102121329 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE location ADD name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE machine ADD name VARCHAR(255) NOT NULL, ADD cpu VARCHAR(255) NOT NULL, ADD storage VARCHAR(255) NOT NULL, ADD ram VARCHAR(255) NOT NULL, ADD price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP first_name, DROP last_name, DROP email');
        $this->addSql('ALTER TABLE location DROP name');
        $this->addSql('ALTER TABLE machine DROP name, DROP cpu, DROP storage, DROP ram, DROP price');
    }
}
