<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614052147 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe CHANGE etat etat TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE module CHANGE etat etat TINYINT(1) DEFAULT NULL');
        $this->addSql('ALTER TABLE personne ADD etat TINYINT(1) DEFAULT NULL, DROP eta1');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe CHANGE etat etat TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE module CHANGE etat etat TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE personne ADD eta1 TINYINT(1) DEFAULT 1 NOT NULL, DROP etat');
    }
}
