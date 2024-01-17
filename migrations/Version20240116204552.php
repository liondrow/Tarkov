<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116204552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD quest_branch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A8BC191 FOREIGN KEY (quest_branch_id) REFERENCES quest_branch (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6497A8BC191 ON user (quest_branch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A8BC191');
        $this->addSql('DROP INDEX IDX_8D93D6497A8BC191 ON user');
        $this->addSql('ALTER TABLE user DROP quest_branch_id');
    }
}
