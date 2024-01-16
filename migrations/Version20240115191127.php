<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240115191127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, team_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7C68921FE48FD905 (game_id), INDEX IDX_7C68921F296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921F296CD8AE FOREIGN KEY (team_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD enabled TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921FE48FD905');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921F296CD8AE');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('ALTER TABLE user DROP enabled');
    }
}
