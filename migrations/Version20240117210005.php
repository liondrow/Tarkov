<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240117210005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE market_item (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, buyer_id INT DEFAULT NULL, game_id INT NOT NULL, item VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, enabled TINYINT(1) DEFAULT NULL, created DATE NOT NULL, updated DATETIME DEFAULT NULL, INDEX IDX_5017DCAE8DE820D9 (seller_id), INDEX IDX_5017DCAE6C755722 (buyer_id), INDEX IDX_5017DCAEE48FD905 (game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE6C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE8DE820D9');
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE6C755722');
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAEE48FD905');
        $this->addSql('DROP TABLE market_item');
    }
}
