<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519222138 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment_mode (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE relay_point (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, label VARCHAR(255) NOT NULL, INDEX IDX_A9BE6C9CF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE relay_point ADD CONSTRAINT FK_A9BE6C9CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE client ADD country_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_C7440455F92F3E70 ON client (country_id)');
        $this->addSql('ALTER TABLE command ADD status_id INT NOT NULL, ADD payment_mode_id INT NOT NULL, ADD relaypoint_id INT NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD46BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD46EAC8BA0 FOREIGN KEY (payment_mode_id) REFERENCES payment_mode (id)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4F8CC9BA1 FOREIGN KEY (relaypoint_id) REFERENCES relay_point (id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD46BF700BD ON command (status_id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD46EAC8BA0 ON command (payment_mode_id)');
        $this->addSql('CREATE INDEX IDX_8ECAEAD4F8CC9BA1 ON command (relaypoint_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455F92F3E70');
        $this->addSql('ALTER TABLE relay_point DROP FOREIGN KEY FK_A9BE6C9CF92F3E70');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD46EAC8BA0');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4F8CC9BA1');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD46BF700BD');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE payment_mode');
        $this->addSql('DROP TABLE relay_point');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP INDEX IDX_C7440455F92F3E70 ON client');
        $this->addSql('ALTER TABLE client DROP country_id');
        $this->addSql('DROP INDEX IDX_8ECAEAD46BF700BD ON command');
        $this->addSql('DROP INDEX IDX_8ECAEAD46EAC8BA0 ON command');
        $this->addSql('DROP INDEX IDX_8ECAEAD4F8CC9BA1 ON command');
        $this->addSql('ALTER TABLE command DROP status_id, DROP payment_mode_id, DROP relaypoint_id');
    }
}
