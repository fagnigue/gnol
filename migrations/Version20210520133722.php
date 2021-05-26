<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210520133722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE deliver_mode (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, prix NUMERIC(10, 2) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE command ADD deliver_mode_id INT NOT NULL, CHANGE relaypoint_id relaypoint_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4AFDEF096 FOREIGN KEY (deliver_mode_id) REFERENCES deliver_mode (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4AFDEF096 ON command (deliver_mode_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4AFDEF096');
        $this->addSql('DROP TABLE deliver_mode');
        $this->addSql('DROP INDEX IDX_8ECAEAD4AFDEF096 ON command');
        $this->addSql('ALTER TABLE command DROP deliver_mode_id, CHANGE relaypoint_id relaypoint_id INT NOT NULL');
    }
}
