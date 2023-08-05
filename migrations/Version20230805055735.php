<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230805055735 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Fixed spelling mistake in album entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album ADD released_year INT DEFAULT NULL, DROP realesed_year');
        $this->addSql('ALTER TABLE band CHANGE country country VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album ADD realesed_year INT NOT NULL, DROP released_year');
        $this->addSql('ALTER TABLE band CHANGE country country VARCHAR(255) NOT NULL');
    }
}
