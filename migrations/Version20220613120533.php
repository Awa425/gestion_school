<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613120533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ac (id INT NOT NULL, rp_id INT DEFAULT NULL, INDEX IDX_E98478FBB70FF80C (rp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE annee_scolaire (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(20) DEFAULT NULL, etat TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, rp_id INT DEFAULT NULL, niveau VARCHAR(30) NOT NULL, filliere VARCHAR(30) NOT NULL, libelle VARCHAR(50) NOT NULL, INDEX IDX_8F87BF96B70FF80C (rp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT NOT NULL, matricule VARCHAR(50) DEFAULT NULL, sexe TINYINT(1) NOT NULL, adresse LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, anneescolaire_id_id INT NOT NULL, ac_id INT NOT NULL, etudiant_id INT NOT NULL, classes_id INT NOT NULL, INDEX IDX_5E90F6D67FA44D (anneescolaire_id_id), INDEX IDX_5E90F6D6D2E3ED2F (ac_id), INDEX IDX_5E90F6D6DDEAB1A3 (etudiant_id), INDEX IDX_5E90F6D69E225B24 (classes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE personne (id INT AUTO_INCREMENT NOT NULL, nom_complet VARCHAR(50) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur (id INT NOT NULL, rp_id INT NOT NULL, grade VARCHAR(30) NOT NULL, INDEX IDX_17A55299B70FF80C (rp_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur_module (professeur_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_BB082478BAB22EE9 (professeur_id), INDEX IDX_BB082478AFC2B591 (module_id), PRIMARY KEY(professeur_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE professeur_classe (professeur_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_38ABBDC6BAB22EE9 (professeur_id), INDEX IDX_38ABBDC68F5EA509 (classe_id), PRIMARY KEY(professeur_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rp (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ac ADD CONSTRAINT FK_E98478FBB70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE ac ADD CONSTRAINT FK_E98478FBBF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D67FA44D FOREIGN KEY (anneescolaire_id_id) REFERENCES annee_scolaire (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6D2E3ED2F FOREIGN KEY (ac_id) REFERENCES ac (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D69E225B24 FOREIGN KEY (classes_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299B70FF80C FOREIGN KEY (rp_id) REFERENCES rp (id)');
        $this->addSql('ALTER TABLE professeur ADD CONSTRAINT FK_17A55299BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_module ADD CONSTRAINT FK_BB082478BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_module ADD CONSTRAINT FK_BB082478AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_classe ADD CONSTRAINT FK_38ABBDC6BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_classe ADD CONSTRAINT FK_38ABBDC68F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE rp ADD CONSTRAINT FK_CD578B7BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BF396750 FOREIGN KEY (id) REFERENCES personne (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6D2E3ED2F');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D67FA44D');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D69E225B24');
        $this->addSql('ALTER TABLE professeur_classe DROP FOREIGN KEY FK_38ABBDC68F5EA509');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6DDEAB1A3');
        $this->addSql('ALTER TABLE professeur_module DROP FOREIGN KEY FK_BB082478AFC2B591');
        $this->addSql('ALTER TABLE ac DROP FOREIGN KEY FK_E98478FBBF396750');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3BF396750');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299BF396750');
        $this->addSql('ALTER TABLE rp DROP FOREIGN KEY FK_CD578B7BF396750');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BF396750');
        $this->addSql('ALTER TABLE professeur_module DROP FOREIGN KEY FK_BB082478BAB22EE9');
        $this->addSql('ALTER TABLE professeur_classe DROP FOREIGN KEY FK_38ABBDC6BAB22EE9');
        $this->addSql('ALTER TABLE ac DROP FOREIGN KEY FK_E98478FBB70FF80C');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96B70FF80C');
        $this->addSql('ALTER TABLE professeur DROP FOREIGN KEY FK_17A55299B70FF80C');
        $this->addSql('DROP TABLE ac');
        $this->addSql('DROP TABLE annee_scolaire');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE personne');
        $this->addSql('DROP TABLE professeur');
        $this->addSql('DROP TABLE professeur_module');
        $this->addSql('DROP TABLE professeur_classe');
        $this->addSql('DROP TABLE rp');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
