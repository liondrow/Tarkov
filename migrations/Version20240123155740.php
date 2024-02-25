<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123155740 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE shelter (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, target LONGTEXT DEFAULT NULL, bonus LONGTEXT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_71106707E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_shelter (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, team_id INT NOT NULL, shelter_id INT NOT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_8E691630E48FD905 (game_id), INDEX IDX_8E691630296CD8AE (team_id), INDEX IDX_8E69163054053EC0 (shelter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE shelter ADD CONSTRAINT FK_71106707E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE team_shelter ADD CONSTRAINT FK_8E691630E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE team_shelter ADD CONSTRAINT FK_8E691630296CD8AE FOREIGN KEY (team_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE team_shelter ADD CONSTRAINT FK_8E69163054053EC0 FOREIGN KEY (shelter_id) REFERENCES shelter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE shelter DROP FOREIGN KEY FK_71106707E48FD905');
        $this->addSql('ALTER TABLE team_shelter DROP FOREIGN KEY FK_8E691630E48FD905');
        $this->addSql('ALTER TABLE team_shelter DROP FOREIGN KEY FK_8E691630296CD8AE');
        $this->addSql('ALTER TABLE team_shelter DROP FOREIGN KEY FK_8E69163054053EC0');
        $this->addSql('DROP TABLE shelter');
        $this->addSql('DROP TABLE team_shelter');
    }
}
