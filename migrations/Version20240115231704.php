<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115231704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE invoice_journal (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, team_from_id INT NOT NULL, team_to_id INT NOT NULL, sum DOUBLE PRECISION DEFAULT NULL, request LONGTEXT DEFAULT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_337ED19EE48FD905 (game_id), INDEX IDX_337ED19E87B7A83C (team_from_id), INDEX IDX_337ED19EF7330325 (team_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19E87B7A83C FOREIGN KEY (team_from_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19EF7330325 FOREIGN KEY (team_to_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19EE48FD905');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19E87B7A83C');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19EF7330325');
        $this->addSql('DROP TABLE invoice_journal');
    }
}
