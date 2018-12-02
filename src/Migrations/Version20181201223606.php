<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181201223606 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE podcast (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_D7E805BDA76ED395 ON podcast (user_id)');
        $this->addSql('CREATE TABLE episode (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, podcast_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, published_at DATETIME NOT NULL, enclosure_url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA786136AB ON episode (podcast_id)');
        $this->addSql('CREATE TABLE setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(50) NOT NULL, value CLOB DEFAULT NULL)');

        $this->addSql("INSERT INTO setting(name, value) VALUES('hasBeenInstalled','false')");
        $this->addSql("INSERT INTO setting(name, value) VALUES('doesPodcastInformationExist','false')");
        $this->addSql("INSERT INTO setting(name, value) VALUES('doesUserInformationExist','false')");
        $this->addSql("INSERT INTO setting(name, value) VALUES('isOnline','true')");
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE podcast');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE setting');
    }
}
