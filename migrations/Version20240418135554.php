<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418135554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19E87B7A83C');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19EF7330325');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19E87B7A83C FOREIGN KEY (team_from_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19EF7330325 FOREIGN KEY (team_to_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19E87B7A83C');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19EF7330325');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19E87B7A83C FOREIGN KEY (team_from_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19EF7330325 FOREIGN KEY (team_to_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
