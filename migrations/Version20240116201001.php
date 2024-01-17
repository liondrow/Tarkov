<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116201001 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, target_id INT DEFAULT NULL, branch_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, reward DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4317F817158E0B66 (target_id), INDEX IDX_4317F817DCD6CC49 (branch_id), INDEX IDX_4317F817727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_branch (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_426C79E9E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_progress (id INT AUTO_INCREMENT NOT NULL, quest_id INT NOT NULL, team_id INT NOT NULL, status VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_C35B4DE3209E9EF4 (quest_id), INDEX IDX_C35B4DE3296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817158E0B66 FOREIGN KEY (target_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817DCD6CC49 FOREIGN KEY (branch_id) REFERENCES quest_branch (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817727ACA70 FOREIGN KEY (parent_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_branch ADD CONSTRAINT FK_426C79E9E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE quest_progress ADD CONSTRAINT FK_C35B4DE3209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_progress ADD CONSTRAINT FK_C35B4DE3296CD8AE FOREIGN KEY (team_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817158E0B66');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817DCD6CC49');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817727ACA70');
        $this->addSql('ALTER TABLE quest_branch DROP FOREIGN KEY FK_426C79E9E48FD905');
        $this->addSql('ALTER TABLE quest_progress DROP FOREIGN KEY FK_C35B4DE3209E9EF4');
        $this->addSql('ALTER TABLE quest_progress DROP FOREIGN KEY FK_C35B4DE3296CD8AE');
        $this->addSql('DROP TABLE quest');
        $this->addSql('DROP TABLE quest_branch');
        $this->addSql('DROP TABLE quest_progress');
    }
}
