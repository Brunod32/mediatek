<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512192630 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album (id INT AUTO_INCREMENT NOT NULL, band_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, released_year INT DEFAULT NULL, album_cover LONGTEXT DEFAULT NULL, INDEX IDX_39986E4349ABEB17 (band_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE band (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, picture LONGTEXT DEFAULT NULL, creation_year INT DEFAULT NULL, INDEX IDX_48DFA2EBF92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, writer_id INT DEFAULT NULL, style_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, nb_pages INT DEFAULT NULL, book_cover LONGTEXT DEFAULT NULL, synopsis LONGTEXT DEFAULT NULL, released_year INT DEFAULT NULL, INDEX IDX_CBE5A3311BC7E6B6 (writer_id), INDEX IDX_CBE5A331BACD6074 (style_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE literary_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metal_style (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(25) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE writer (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, picture LONGTEXT DEFAULT NULL, INDEX IDX_97A0D882F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4349ABEB17 FOREIGN KEY (band_id) REFERENCES band (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EBF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE band ADD style_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE band ADD CONSTRAINT FK_48DFA2EBBACD6074 FOREIGN KEY (style_id) REFERENCES metal_style (id)');
        $this->addSql('CREATE INDEX IDX_48DFA2EBBACD6074 ON band (style_id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331BACD6074 FOREIGN KEY (style_id) REFERENCES literary_style (id)');
        $this->addSql('ALTER TABLE writer ADD CONSTRAINT FK_97A0D882F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4349ABEB17');
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EBF92F3E70');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BC7E6B6');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331BACD6074');
        $this->addSql('ALTER TABLE writer DROP FOREIGN KEY FK_97A0D882F92F3E70');
        $this->addSql('ALTER TABLE band DROP FOREIGN KEY FK_48DFA2EBBACD6074');
        $this->addSql('DROP TABLE album');
        $this->addSql('DROP TABLE band');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE literary_style');
        $this->addSql('DROP TABLE metal_style');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE writer');
        $this->addSql('DROP INDEX IDX_48DFA2EBBACD6074 ON band');
    }
}
