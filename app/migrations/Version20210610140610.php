<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210610140610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users CHANGE id id INT UNSIGNED AUTO_INCREMENT NOT NULL, CHANGE username username VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX username_idx ON users (username)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX username_idx ON users');
        $this->addSql('ALTER TABLE users CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE username username VARCHAR(32) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
