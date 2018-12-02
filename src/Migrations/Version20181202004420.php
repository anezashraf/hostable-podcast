<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181202004420 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DDAA1CDA786136AB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__episode AS SELECT id, podcast_id, title, description, published_at, enclosure_url FROM episode');
        $this->addSql('DROP TABLE episode');
        $this->addSql('CREATE TABLE episode (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, podcast_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, published_at DATETIME NOT NULL, enclosure_url VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_DDAA1CDA786136AB FOREIGN KEY (podcast_id) REFERENCES podcast (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO episode (id, podcast_id, title, description, published_at, enclosure_url) SELECT id, podcast_id, title, description, published_at, enclosure_url FROM __temp__episode');
        $this->addSql('DROP TABLE __temp__episode');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA786136AB ON episode (podcast_id)');
        $this->addSql('DROP INDEX IDX_D7E805BDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__podcast AS SELECT id, user_id, title, description, image FROM podcast');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_D7E805BDA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO podcast (id, user_id, title, description, image) SELECT id, user_id, title, description, image FROM __temp__podcast');
        $this->addSql('DROP TABLE __temp__podcast');
        $this->addSql('CREATE INDEX IDX_D7E805BDA76ED395 ON podcast (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_DDAA1CDA786136AB');
        $this->addSql('CREATE TEMPORARY TABLE __temp__episode AS SELECT id, podcast_id, title, description, published_at, enclosure_url FROM episode');
        $this->addSql('DROP TABLE episode');
        $this->addSql('CREATE TABLE episode (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, podcast_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, published_at DATETIME NOT NULL, enclosure_url VARCHAR(255) NOT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO episode (id, podcast_id, title, description, published_at, enclosure_url) SELECT id, podcast_id, title, description, published_at, enclosure_url FROM __temp__episode');
        $this->addSql('DROP TABLE __temp__episode');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA786136AB ON episode (podcast_id)');
        $this->addSql('DROP INDEX IDX_D7E805BDA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__podcast AS SELECT id, user_id, title, description, image FROM podcast');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO podcast (id, user_id, title, description, image) SELECT id, user_id, title, description, image FROM __temp__podcast');
        $this->addSql('DROP TABLE __temp__podcast');
        $this->addSql('CREATE INDEX IDX_D7E805BDA76ED395 ON podcast (user_id)');
    }
}
