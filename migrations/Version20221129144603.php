<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221129144603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, listeevents_id INT NOT NULL, listesponsors_id INT NOT NULL, montants DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_31E581A0AF770EFF (listeevents_id), INDEX IDX_31E581A08AAE4652 (listesponsors_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0AF770EFF FOREIGN KEY (listeevents_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A08AAE4652 FOREIGN KEY (listesponsors_id) REFERENCES sponsor (id)');
        $this->addSql('ALTER TABLE evenement_sponsor DROP FOREIGN KEY FK_8289DE0812F7FB51');
        $this->addSql('ALTER TABLE evenement_sponsor DROP FOREIGN KEY FK_8289DE08FD02F13');
        $this->addSql('DROP TABLE evenement_sponsor');
        $this->addSql('DROP TABLE user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_sponsor (evenement_id INT NOT NULL, sponsor_id INT NOT NULL, INDEX IDX_8289DE08FD02F13 (evenement_id), INDEX IDX_8289DE0812F7FB51 (sponsor_id), PRIMARY KEY(evenement_id, sponsor_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement_sponsor ADD CONSTRAINT FK_8289DE0812F7FB51 FOREIGN KEY (sponsor_id) REFERENCES sponsor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_sponsor ADD CONSTRAINT FK_8289DE08FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A0AF770EFF');
        $this->addSql('ALTER TABLE donation DROP FOREIGN KEY FK_31E581A08AAE4652');
        $this->addSql('DROP TABLE donation');
    }
}
