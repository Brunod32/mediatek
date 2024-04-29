<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230612113410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create relation band-albums';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album ADD band_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE album ADD CONSTRAINT FK_39986E4349ABEB17 FOREIGN KEY (band_id) REFERENCES band (id)');
        $this->addSql('CREATE INDEX IDX_39986E4349ABEB17 ON album (band_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album DROP FOREIGN KEY FK_39986E4349ABEB17');
        $this->addSql('DROP INDEX IDX_39986E4349ABEB17 ON album');
        $this->addSql('ALTER TABLE album DROP band_id');
    }
}
