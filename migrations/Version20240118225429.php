<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118225429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE market_invoice (id INT AUTO_INCREMENT NOT NULL, lot_id INT NOT NULL, buyer_id INT NOT NULL, date DATETIME NOT NULL, INDEX IDX_99F3FFC4A8CBA5F7 (lot_id), INDEX IDX_99F3FFC46C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE market_invoice ADD CONSTRAINT FK_99F3FFC4A8CBA5F7 FOREIGN KEY (lot_id) REFERENCES market_item (id)');
        $this->addSql('ALTER TABLE market_invoice ADD CONSTRAINT FK_99F3FFC46C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE6C755722');
        $this->addSql('DROP INDEX IDX_5017DCAE6C755722 ON market_item');
        $this->addSql('ALTER TABLE market_item DROP buyer_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_invoice DROP FOREIGN KEY FK_99F3FFC4A8CBA5F7');
        $this->addSql('ALTER TABLE market_invoice DROP FOREIGN KEY FK_99F3FFC46C755722');
        $this->addSql('DROP TABLE market_invoice');
        $this->addSql('ALTER TABLE market_item ADD buyer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE6C755722 FOREIGN KEY (buyer_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5017DCAE6C755722 ON market_item (buyer_id)');
    }
}
