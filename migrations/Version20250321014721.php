<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321014721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790D296CD8AE');
        $this->addSql('DROP INDEX IDX_291D790D296CD8AE ON user_shelter');
        $this->addSql('ALTER TABLE user_shelter CHANGE team_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_291D790DA76ED395 ON user_shelter (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_shelter DROP FOREIGN KEY FK_291D790DA76ED395');
        $this->addSql('DROP INDEX IDX_291D790DA76ED395 ON user_shelter');
        $this->addSql('ALTER TABLE user_shelter CHANGE user_id team_id INT NOT NULL');
        $this->addSql('ALTER TABLE user_shelter ADD CONSTRAINT FK_291D790D296CD8AE FOREIGN KEY (team_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_291D790D296CD8AE ON user_shelter (team_id)');
    }
}
