<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321004843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created DATE DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, map_x VARCHAR(255) DEFAULT NULL, map_y VARCHAR(255) DEFAULT NULL, date_end DATE DEFAULT NULL, polygon VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice_journal (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, user_from_id INT NOT NULL, user_to_id INT NOT NULL, sum DOUBLE PRECISION DEFAULT NULL, request LONGTEXT DEFAULT NULL, create_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', type VARCHAR(255) DEFAULT NULL, INDEX IDX_337ED19EE48FD905 (game_id), INDEX IDX_337ED19E20C3C701 (user_from_id), INDEX IDX_337ED19ED2F7B13D (user_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_invoice (id INT AUTO_INCREMENT NOT NULL, lot_id INT NOT NULL, buyer_id INT NOT NULL, date DATETIME NOT NULL, delivered TINYINT(1) DEFAULT NULL, INDEX IDX_99F3FFC4A8CBA5F7 (lot_id), INDEX IDX_99F3FFC46C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market_item (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, game_id INT NOT NULL, item VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, enabled TINYINT(1) DEFAULT NULL, created DATETIME NOT NULL, updated DATETIME DEFAULT NULL, comission DOUBLE PRECISION DEFAULT NULL, INDEX IDX_5017DCAE8DE820D9 (seller_id), INDEX IDX_5017DCAEE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest (id INT AUTO_INCREMENT NOT NULL, target_id INT DEFAULT NULL, branch_id INT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, reward DOUBLE PRECISION DEFAULT NULL, INDEX IDX_4317F817158E0B66 (target_id), INDEX IDX_4317F817DCD6CC49 (branch_id), INDEX IDX_4317F817727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_branch (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_426C79E9E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quest_progress (id INT AUTO_INCREMENT NOT NULL, quest_id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(255) NOT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_C35B4DE3209E9EF4 (quest_id), INDEX IDX_C35B4DE3A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shelter (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, bonus LONGTEXT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_71106707E48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, quest_branch_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL, airsoft_team VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', enabled TINYINT(1) DEFAULT NULL, seller TINYINT(1) DEFAULT NULL, is_auctioner TINYINT(1) DEFAULT NULL, is_pmc TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D6497A8BC191 (quest_branch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_game (user_id INT NOT NULL, game_id INT NOT NULL, INDEX IDX_59AA7D45A76ED395 (user_id), INDEX IDX_59AA7D45E48FD905 (game_id), PRIMARY KEY(user_id, game_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_shelter (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, team_id INT NOT NULL, shelter_id INT NOT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_291D790DE48FD905 (game_id), INDEX IDX_291D790D296CD8AE (team_id), INDEX IDX_291D790D54053EC0 (shelter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wallet (id INT AUTO_INCREMENT NOT NULL, game_id INT NOT NULL, user_id INT NOT NULL, value DOUBLE PRECISION DEFAULT NULL, INDEX IDX_7C68921FE48FD905 (game_id), INDEX IDX_7C68921FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19EE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19E20C3C701 FOREIGN KEY (user_from_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice_journal ADD CONSTRAINT FK_337ED19ED2F7B13D FOREIGN KEY (user_to_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE market_invoice ADD CONSTRAINT FK_99F3FFC4A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES market_item (id)');
        $this->addSql('ALTER TABLE market_invoice ADD CONSTRAINT FK_99F3FFC46C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817158E0B66 FOREIGN KEY (target_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817DCD6CC49 FOREIGN KEY (branch_id) REFERENCES quest_branch (id)');
        $this->addSql('ALTER TABLE quest ADD CONSTRAINT FK_4317F817727ACA70 FOREIGN KEY (parent_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_branch ADD CONSTRAINT FK_426C79E9E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE quest_progress ADD CONSTRAINT FK_C35B4DE3209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('ALTER TABLE quest_progress ADD CONSTRAINT FK_C35B4DE3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shelter ADD CONSTRAINT FK_71106707E48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6497A8BC191 FOREIGN KEY (quest_branch_id) REFERENCES quest_branch (id)');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_game ADD CONSTRAINT FK_59AA7D45E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790DE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790D296CD8AE FOREIGN KEY (team_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790D54053EC0 FOREIGN KEY (shelter_id) REFERENCES shelter (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
        $this->addSql('ALTER TABLE wallet ADD CONSTRAINT FK_7C68921FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19EE48FD905');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19E20C3C701');
        $this->addSql('ALTER TABLE invoice_journal DROP FOREIGN KEY FK_337ED19ED2F7B13D');
        $this->addSql('ALTER TABLE market_invoice DROP FOREIGN KEY FK_99F3FFC4A8CBA5F7');
        $this->addSql('ALTER TABLE market_invoice DROP FOREIGN KEY FK_99F3FFC46C755722');
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE8DE820D9');
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAEE48FD905');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817158E0B66');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817DCD6CC49');
        $this->addSql('ALTER TABLE quest DROP FOREIGN KEY FK_4317F817727ACA70');
        $this->addSql('ALTER TABLE quest_branch DROP FOREIGN KEY FK_426C79E9E48FD905');
        $this->addSql('ALTER TABLE quest_progress DROP FOREIGN KEY FK_C35B4DE3209E9EF4');
        $this->addSql('ALTER TABLE quest_progress DROP FOREIGN KEY FK_C35B4DE3A76ED395');
        $this->addSql('ALTER TABLE shelter DROP FOREIGN KEY FK_71106707E48FD905');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6497A8BC191');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45A76ED395');
        $this->addSql('ALTER TABLE user_game DROP FOREIGN KEY FK_59AA7D45E48FD905');
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790DE48FD905');
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790D296CD8AE');
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790D54053EC0');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921FE48FD905');
        $this->addSql('ALTER TABLE wallet DROP FOREIGN KEY FK_7C68921FA76ED395');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE invoice_journal');
        $this->addSql('DROP TABLE market_invoice');
        $this->addSql('DROP TABLE market_item');
        $this->addSql('DROP TABLE quest');
        $this->addSql('DROP TABLE quest_branch');
        $this->addSql('DROP TABLE quest_progress');
        $this->addSql('DROP TABLE shelter');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_game');
        $this->addSql('DROP TABLE user_shelter');
        $this->addSql('DROP TABLE wallet');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
