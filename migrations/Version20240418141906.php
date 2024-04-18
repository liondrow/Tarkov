<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240418141906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE8DE820D9');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE market_item DROP FOREIGN KEY FK_5017DCAE8DE820D9');
        $this->addSql('ALTER TABLE market_item ADD CONSTRAINT FK_5017DCAE8DE820D9 FOREIGN KEY (seller_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
