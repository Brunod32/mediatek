<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424181452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE band ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_48DFA2EBF92F3E70 ON band (country_id)');
        $this->addSql('ALTER TABLE writer ADD country_id INT DEFAULT NULL, DROP country');
        $this->addSql('ALTER TABLE writer ADD CONSTRAINT FK_97A0D882F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_97A0D882F92F3E70 ON writer (country_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EBF92F3E70');
        $this->addSql('ALTER TABLE writer DROP FOREIGN KEY FK_97A0D882F92F3E70');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP INDEX IDX_48DFA2EBF92F3E70 ON band');
        $this->addSql('ALTER TABLE band ADD country VARCHAR(255) DEFAULT NULL, DROP country_id');
        $this->addSql('DROP INDEX IDX_97A0D882F92F3E70 ON writer');
        $this->addSql('ALTER TABLE writer ADD country VARCHAR(255) DEFAULT NULL, DROP country_id');
    }
}
