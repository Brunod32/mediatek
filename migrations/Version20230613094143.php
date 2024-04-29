<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613094143 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create relation Writer-Book';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book ADD writer_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A3311BC7E6B6 FOREIGN KEY (writer_id) REFERENCES writer (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A3311BC7E6B6 ON book (writer_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A3311BC7E6B6');
        $this->addSql('DROP INDEX IDX_CBE5A3311BC7E6B6 ON book');
        $this->addSql('ALTER TABLE book DROP writer_id');
    }
}
