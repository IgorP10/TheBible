<?php

declare(strict_types=1);

namespace Migration\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914210046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create tables for Bible books, chapters, verses, versions, and verses content';
    }

    public function up(Schema $schema): void
    {
        // Create 'books' table
        $books = $schema->createTable('books');
        $books->addColumn('id', 'integer', ['autoincrement' => true]);
        $books->addColumn('abbreviation', 'string', ['length' => 10]);
        $books->addColumn('name', 'string', ['length' => 255]);
        $books->addColumn('testament', 'string', ['length' => 3]); // 'Old' or 'New'
        $books->setPrimaryKey(['id']);

        // Create 'chapters' table
        $chapters = $schema->createTable('chapters');
        $chapters->addColumn('id', 'integer', options: ['autoincrement' => true]);
        $chapters->addColumn('book_id', 'integer');
        $chapters->addColumn('chapter_number', 'integer');
        $chapters->setPrimaryKey(['id']);
        $chapters->addForeignKeyConstraint('books', ['book_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_chapters_book');

        // Create 'verses' table
        $verses = $schema->createTable('verses');
        $verses->addColumn('id', 'integer', ['autoincrement' => true]);
        $verses->addColumn('chapter_id', 'integer');
        $verses->addColumn('verse_number', 'integer');
        $verses->setPrimaryKey(['id']);
        $verses->addForeignKeyConstraint('chapters', ['chapter_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_verses_chapter');

        // Create 'versions' table
        $versions = $schema->createTable('versions');
        $versions->addColumn('id', 'integer', ['autoincrement' => true]);
        $versions->addColumn('version_code', 'string', ['length' => 10]);
        $versions->addColumn('description', 'string', ['length' => 255]);
        $versions->setPrimaryKey(['id']);

        // Create 'verses_content' table
        $versesContent = $schema->createTable('verses_content');
        $versesContent->addColumn('id', 'integer', ['autoincrement' => true]);
        $versesContent->addColumn('verse_id', 'integer');
        $versesContent->addColumn('version_id', 'integer');
        $versesContent->addColumn('content', 'text');
        $versesContent->setPrimaryKey(['id']);
        $versesContent->addForeignKeyConstraint('verses', ['verse_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_verses_content_verse');
        $versesContent->addForeignKeyConstraint('versions', ['version_id'], ['id'], ['onDelete' => 'CASCADE'], 'FK_verses_content_version');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('verses_content');
        $schema->dropTable('versions');
        $schema->dropTable('verses');
        $schema->dropTable('chapters');
        $schema->dropTable('books');
    }
}
