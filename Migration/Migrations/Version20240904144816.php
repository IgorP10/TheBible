<?php

declare(strict_types=1);

namespace Migration\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240904144816 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create transaction_categories table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('transaction_categories');
        $table->addColumn('transaction_id', 'integer');
        $table->addColumn('category_id', 'integer');
        $table->addForeignKeyConstraint('transactions', ['transaction_id'], ['id']);
        $table->addForeignKeyConstraint('categories', ['category_id'], ['id']);
        $table->setPrimaryKey(['transaction_id', 'category_id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('transaction_categories');
    }
}
