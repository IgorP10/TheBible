<?php

declare(strict_types=1);

namespace Migration\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914211532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Update the books table to store JSON in abbreviation and add new columns';
    }

    public function up(Schema $schema): void
    {
        // Alter 'abbreviation' column to store JSON data
        $this->addSql('ALTER TABLE books ALTER COLUMN abbreviation TYPE TEXT');

        // Add new columns
        $this->addSql('ALTER TABLE books ADD author VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD chapters INT DEFAULT NULL');
        $this->addSql('ALTER TABLE books ADD "group" VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // Revert the changes if needed

        // Remove new columns
        $this->addSql('ALTER TABLE books DROP COLUMN author');
        $this->addSql('ALTER TABLE books DROP COLUMN chapters');
        $this->addSql('ALTER TABLE books DROP COLUMN "group"');

        // Revert 'abbreviation' column type
        $this->addSql('ALTER TABLE books ALTER COLUMN abbreviation TYPE VARCHAR(10)');
    }
}
