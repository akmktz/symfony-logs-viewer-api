<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220505183419 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE log_file (id INT AUTO_INCREMENT NOT NULL, log_name VARCHAR(255) NOT NULL, cached_size BIGINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE log_file_item (id INT AUTO_INCREMENT NOT NULL, log_file_id_id INT NOT NULL, date_time DATETIME NOT NULL, data LONGTEXT NOT NULL, INDEX IDX_80E5D1FEDFD182DB (log_file_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE log_file_item ADD CONSTRAINT FK_80E5D1FEDFD182DB FOREIGN KEY (log_file_id_id) REFERENCES log_file (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE log_file_item DROP FOREIGN KEY FK_80E5D1FEDFD182DB');
        $this->addSql('DROP TABLE log_file');
        $this->addSql('DROP TABLE log_file_item');
    }
}
