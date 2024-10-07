<?php

declare(strict_types=1);

namespace Migration\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20241004204613 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Renames column chapters to total_chapters in the desired table';
    }

    public function up(Schema $schema): void
    {
        // Renomear a coluna 'chapters' para 'total_chapters'
        $this->addSql('ALTER TABLE books RENAME COLUMN chapters TO total_chapters');
    }

    public function down(Schema $schema): void
    {
        // Reverter a mudança, renomeando a coluna 'total_chapters' de volta para 'chapters'
        $this->addSql('ALTER TABLE books RENAME COLUMN total_chapters TO chapters');
    }
}
